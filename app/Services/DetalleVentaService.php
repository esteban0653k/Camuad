<?php

namespace App\Services;

use App\Interfaces\DetalleVentaInterface;

class DetalleVentaService
{
    public function __construct(private DetalleVentaInterface $detalleVentaRepository)
    {
    }

    public function listarDetalles()
    {
        return $this->detalleVentaRepository->getAll();
    }

    public function listarDetallesPorVenta(int $idVenta)
    {
        return $this->detalleVentaRepository->getDetallesPorVenta($idVenta);
    }

    public function obtenerDetallePorId(string|int $id)
    {
        return $this->detalleVentaRepository->getById($id);
    }

    public function crearDetalle(array $data)
    {
        // Cálculo automático del subtotal del detalle unitario
        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];

        // Estado por defecto (debe coincidir con el default de la migración)
        $data['estado_venta'] = $data['estado_venta'] ?? 'activa';

        return $this->detalleVentaRepository->create($data);
    }

    public function actualizarDetalle(string|int $id, array $data)
    {
        // Si cambia solo uno de los dos valores, se toma el otro del registro actual
        if (isset($data['cantidad']) || isset($data['precio_unitario'])) {
            $actual = $this->detalleVentaRepository->getById($id);

            $cantidad = $data['cantidad'] ?? $actual->cantidad;
            $precio   = $data['precio_unitario'] ?? $actual->precio_unitario;

            $data['subtotal'] = $cantidad * $precio;
        }

        return $this->detalleVentaRepository->update($id, $data);
    }

    public function eliminarDetalle(string|int $id)
    {
        return $this->detalleVentaRepository->delete($id);
    }
}