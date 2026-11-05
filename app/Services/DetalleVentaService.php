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

    public function obtenerDetallePorId(string $id)
    {
        return $this->detalleVentaRepository->getById($id);
    }

    public function crearDetalle(array $data)
    {
        // Cálculo automático del subtotal por línea
        $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        return $this->detalleVentaRepository->create($data);
    }

    public function actualizarDetalle(string $id, array $data)
    {
        if (isset($data['cantidad']) && isset($data['precio_unitario'])) {
            $data['subtotal'] = $data['cantidad'] * $data['precio_unitario'];
        }
        return $this->detalleVentaRepository->update($id, $data);
    }

    public function eliminarDetalle(string $id)
    {
        return $this->detalleVentaRepository->delete($id);
    }
}