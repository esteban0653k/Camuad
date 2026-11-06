<?php

namespace App\Services;

use App\Interfaces\FacturaInterface;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FacturaService
{
    public function __construct(private FacturaInterface $facturaRepository)
    {
    }

    public function listarFacturas()
    {
        return $this->facturaRepository->getFacturasConCliente();
    }

    public function obtenerFacturaPorId(string $id)
    {
        return $this->facturaRepository->getById($id);
    }

    public function crearFacturaConDetalles(array $data)
    {
        return DB::transaction(function () use ($data) {
            $subtotalGeneral = 0;
            $detallesCalculados = [];

            if (isset($data['detalles']) && is_array($data['detalles'])) {
                foreach ($data['detalles'] as $detalle) {
                    // 1. Buscar el producto por su SKU
                    $producto = Producto::where('sku', $detalle['id_producto'])->first();

                    if (!$producto) {
                        throw ValidationException::withMessages([
                            'detalles' => ["El producto con SKU {$detalle['id_producto']} no existe."]
                        ]);
                    }

                    // 2. Validar que exista suficiente stock en inventario
                    if ($producto->stock < $detalle['cantidad']) {
                        throw ValidationException::withMessages([
                            'detalles' => ["Stock insuficiente para '{$producto->nombre_producto}'. Disponible: {$producto->stock}, solicitado: {$detalle['cantidad']}."]
                        ]);
                    }

                    // 3. Descontar el stock automáticamente
                    $producto->stock -= $detalle['cantidad'];
                    $producto->save();

                    // 4. Calcular el subtotal de esta línea de producto
                    $subtotalLinea = $detalle['cantidad'] * $detalle['precio_unitario'];
                    $subtotalGeneral += $subtotalLinea;

                    $detallesCalculados[] = [
                        'id_producto'     => $detalle['id_producto'],
                        'cantidad'        => $detalle['cantidad'],
                        'precio_unitario' => $detalle['precio_unitario'],
                        'subtotal'        => $subtotalLinea
                    ];
                }
            }

            // 5. Calcular IVA (19%) y el Total general de forma automática
            $porcentajeIva = $data['porcentaje_iva'] ?? 0.19;
            $ivaGeneral = $subtotalGeneral * $porcentajeIva;
            $descuento = $data['descuento'] ?? 0;
            $totalGeneral = ($subtotalGeneral + $ivaGeneral) - $descuento;

            // 6. Gestionar campos financieros nuevos (Método de pago, monto recibido y cambio)
            $metodoPago = $data['metodo_pago'] ?? 'Efectivo';
            $montoRecibido = $data['monto_recibido'] ?? $totalGeneral;
            
            // Cálculo automático del cambio (si el monto recibido es mayor al total)
            $cambio = isset($data['monto_recibido']) ? max(0, $data['monto_recibido'] - $totalGeneral) : 0;

            // Validar si el dinero en efectivo es menor al total a pagar
            if ($metodoPago === 'Efectivo' && $montoRecibido < $totalGeneral) {
                throw ValidationException::withMessages([
                    'monto_recibido' => ["El monto recibido es menor que el total de la factura."]
                ]);
            }

            // 7. Crear la cabecera de la factura en la base de datos
            $factura = $this->facturaRepository->create([
                'numero_documento_cliente' => $data['numero_documento_cliente'],
                'fecha_factura'            => now(),
                'metodo_pago'              => $metodoPago,
                'monto_recibido'           => $montoRecibido,
                'cambio'                   => $cambio,
                'subtotal'                 => $subtotalGeneral,
                'iva'                      => $ivaGeneral,
                'descuento'                => $descuento,
                'total'                    => $totalGeneral
            ]);
            // 7. Guardar los detalles vinculados a la factura creada
            foreach ($detallesCalculados as $detalle) {
                $factura->detalles()->create([
                    'id_factura'      => $factura->id_factura,
                    'id_producto'     => $detalle['id_producto'],
                    'cantidad'        => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal'        => $detalle['subtotal']
                ]);
            }

            return $factura->load('detalles');
        });
    }

    public function actualizarFactura(string $id, array $data)
    {
        // 1. Buscar la factura existente
        $factura = $this->facturaRepository->getById($id);

        if (!$factura) {
            throw ValidationException::withMessages([
                'id_factura' => ["La factura con ID {$id} no existe."]
            ]);
        }

        // 2. Mantener el subtotal actual y evaluar si hay nuevo descuento
        $subtotalGeneral = $factura->subtotal;
        $descuento = isset($data['descuento']) ? $data['descuento'] : $factura->descuento;
        
        // 3. Recalcular el IVA y el total de forma proporcional
        $ivaGeneral = $subtotalGeneral * 0.19;
        $totalGeneral = ($subtotalGeneral + $ivaGeneral) - $descuento;

        // Manejar actualización de pagos si se envían
        $metodoPago = $data['metodo_pago'] ?? $factura->metodo_pago;
        $montoRecibido = $data['monto_recibido'] ?? $factura->monto_recibido;
        $cambio = isset($data['monto_recibido']) ? max(0, $data['monto_recibido'] - $totalGeneral) : $factura->cambio;

        // 4. Consolidar los datos ya recalculados
        $dataActualizada = [
            'numero_documento_cliente' => $data['numero_documento_cliente'] ?? $factura->numero_documento_cliente,
            'metodo_pago'              => $metodoPago,
            'monto_recibido'           => $montoRecibido,
            'cambio'                   => $cambio,
            'descuento'                => $descuento,
            'iva'                      => $ivaGeneral,
            'total'                    => $totalGeneral
        ];

        // 5. Actualizar en la base de datos a través del repositorio
        return $this->facturaRepository->update($id, $dataActualizada);
    }

    public function eliminarFactura(string $id)
    {
        return $this->facturaRepository->delete($id);
    }
}