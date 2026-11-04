<?php

namespace App\Services;

use App\Interfaces\FacturaInterface;
use Illuminate\Support\Facades\DB;

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
            // 1. Registro de la cabecera de la factura
            $factura = $this->facturaRepository->create([
                'numero_documento_cliente' => $data['numero_documento_cliente'],
                'fecha_factura'            => now(),
                'subtotal'                 => $data['subtotal'],
                'iva'                      => $data['iva'],
                'descuento'                => $data['descuento'] ?? 0,
                'total'                    => $data['total']
            ]);

            // 2. Registro de las líneas asociadas en detalle_venta (si existen en el payload)
            if (isset($data['detalles']) && is_array($data['detalles'])) {
                foreach ($data['detalles'] as $detalle) {
                    $factura->detalles()->create([
                        'id_factura'      => $factura->id_factura,
                        'id_producto'     => $detalle['id_producto'],
                        'cantidad'        => $detalle['cantidad'],
                        'precio_unitario' => $detalle['precio_unitario'],
                        'subtotal_linea'  => $detalle['cantidad'] * $detalle['precio_unitario']
                    ]);
                }
            }

            return $factura->load('detalles');
        });
    }

    public function actualizarFactura(string $id, array $data)
    {
        return $this->facturaRepository->update($id, $data);
    }

    public function eliminarFactura(string $id)
    {
        return $this->facturaRepository->delete($id);
    }
}