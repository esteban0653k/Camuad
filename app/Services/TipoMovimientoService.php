<?php

namespace App\Services;

use App\Interfaces\TipoMovimientoInterface;

class TipoMovimientoService
{
    public function __construct(private TipoMovimientoInterface $tipoMovimientoRepository)
    {
    }

    public function listarTipos()
    {
        return $this->tipoMovimientoRepository->getAll();
    }

    public function obtenerTipoPorId(string|int $id)
    {
        return $this->tipoMovimientoRepository->getById($id);
    }

    public function crearTipo(array $data)
    {
        return $this->tipoMovimientoRepository->create($data);
    }

    public function actualizarTipo(string|int $id, array $data)
    {
        return $this->tipoMovimientoRepository->update($id, $data);
    }

    public function eliminarTipo(string|int $id)
    {
        return $this->tipoMovimientoRepository->delete($id);
    }
}