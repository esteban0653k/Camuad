<?php

namespace App\Services;

use App\Interfaces\VentaInterface;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\TipoMovimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentaService
{
    private const IVA_POR_DEFECTO = 0.19;

    public function __construct(private VentaInterface $ventaRepository)
    {
    }

    public function listarVentas()
    {
        return $this->ventaRepository->getVentasConCliente();
    }

    public function obtenerVentaPorId(string $id)
    {
        return $this->ventaRepository->getById($id);
    }

    public function crearVentaConDetalles(array $data)
    {
        return DB::transaction(function () use ($data) {
            $subtotalGeneral = 0;
            $detallesCalculados = [];

            // Tipo de movimiento para las salidas por venta
            $tipoSalida = TipoMovimiento::where('nombre', 'Salida')->first();

            if (!$tipoSalida) {
                throw ValidationException::withMessages([
                    'tipo_movimiento' => ['No existe el tipo de movimiento "Salida". Créalo primero.']
                ]);
            }

            foreach ($data['detalles'] ?? [] as $detalle) {
                // 1. Buscar el producto por SKU y bloquear la fila para evitar ventas simultáneas
                $producto = Producto::where('sku', $detalle['sku_producto'])
                    ->lockForUpdate()
                    ->first();

                if (!$producto) {
                    throw ValidationException::withMessages([
                        'detalles' => ["El producto con SKU {$detalle['sku_producto']} no existe."]
                    ]);
                }

                // 2. Validar stock
                if ($producto->stock < $detalle['cantidad']) {
                    throw ValidationException::withMessages([
                        'detalles' => ["Stock insuficiente para '{$producto->nombre_producto}'. Disponible: {$producto->stock}, solicitado: {$detalle['cantidad']}."]
                    ]);
                }

                // 3. Descontar stock
                $producto->stock -= $detalle['cantidad'];
                $producto->save();

                // 4. El precio sale del producto, no del request
                $precioUnitario = $producto->precio; // temporal, hasta que se renombre a precio_venta
                $subtotalLinea = $detalle['cantidad'] * $precioUnitario;
                $subtotalGeneral += $subtotalLinea;

                $detallesCalculados[] = [
                    'sku_producto'    => $producto->sku,
                    'cantidad'        => $detalle['cantidad'],
                    'precio_unitario' => $precioUnitario,
                    'subtotal'        => $subtotalLinea,
                ];
            }

            if (empty($detallesCalculados)) {
                throw ValidationException::withMessages([
                    'detalles' => ['La venta debe tener al menos un producto.']
                ]);
            }

            // 5. IVA y total
            $porcentajeIva = $data['porcentaje_iva'] ?? self::IVA_POR_DEFECTO;
            $ivaGeneral = round($subtotalGeneral * $porcentajeIva, 2);
            $descuento = $data['descuento'] ?? 0;
            $totalGeneral = round(($subtotalGeneral + $ivaGeneral) - $descuento, 2);

            // 6. Pago y cambio
            $metodoPago = $data['metodo_pago'] ?? 'Efectivo';
            $montoRecibido = $data['monto_recibido'] ?? $totalGeneral;
            $cambio = max(0, $montoRecibido - $totalGeneral);

            if ($metodoPago === 'Efectivo' && $montoRecibido < $totalGeneral) {
                throw ValidationException::withMessages([
                    'monto_recibido' => ['El monto recibido es menor que el total de la venta.']
                ]);
            }

            // 7. Cabecera de la venta
            $venta = $this->ventaRepository->create([
                'documento_cliente' => $data['documento_cliente'],
                'fecha_venta'       => now(),
                'metodo_pago'       => $metodoPago,
                'monto_recibido'    => $montoRecibido,
                'cambio'            => $cambio,
                'subtotal'          => $subtotalGeneral,
                'iva'               => $ivaGeneral,
                'descuento'         => $descuento,
                'total'             => $totalGeneral,
            ]);

            // 8. Detalles + movimiento de salida por cada producto
            foreach ($detallesCalculados as $detalle) {
                $venta->detalles()->create($detalle + ['estado_venta' => 'activa']);

                Movimiento::create([
                    'fecha_movimiento'   => now(),
                    'cantidad'           => $detalle['cantidad'],
                    'estado'             => 'activo',
                    'id_tipo_movimiento' => $tipoSalida->id_tipo_movimiento,
                    'sku_producto'       => $detalle['sku_producto'],
                    'id_venta'           => $venta->id_venta,
                ]);
            }

            return $venta->load('cliente', 'detalles.producto');
        });
    }

    public function actualizarVenta(string $id, array $data)
    {
        $venta = $this->ventaRepository->getById($id);

        if (!$venta) {
            throw ValidationException::withMessages([
                'id_venta' => ["La venta con ID {$id} no existe."]
            ]);
        }

        // El subtotal sale de los detalles y no se modifica aquí
        $subtotalGeneral = $venta->subtotal;
        $descuento = $data['descuento'] ?? $venta->descuento;

        $ivaGeneral = round($subtotalGeneral * self::IVA_POR_DEFECTO, 2);
        $totalGeneral = round(($subtotalGeneral + $ivaGeneral) - $descuento, 2);

        $metodoPago = $data['metodo_pago'] ?? $venta->metodo_pago;
        $montoRecibido = $data['monto_recibido'] ?? $venta->monto_recibido;
        $cambio = isset($data['monto_recibido'])
            ? max(0, $data['monto_recibido'] - $totalGeneral)
            : $venta->cambio;

        $dataActualizada = [
            'documento_cliente' => $data['documento_cliente'] ?? $venta->documento_cliente,
            'metodo_pago'       => $metodoPago,
            'monto_recibido'    => $montoRecibido,
            'cambio'            => $cambio,
            'descuento'         => $descuento,
            'iva'               => $ivaGeneral,
            'total'             => $totalGeneral,
        ];

        return $this->ventaRepository->update($id, $dataActualizada);
    }

    public function eliminarVenta(string $id)
    {
        return $this->ventaRepository->delete($id);
    }
}