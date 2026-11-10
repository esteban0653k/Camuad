<?php

namespace App\Services;

use App\Interfaces\MovimientoInterface;

class MovimientoService
{
    public function __construct(private MovimientoInterface $movimientoRepository)
    {
    }

    public function listarMovimientos(array $filtros = [])
    {
        return $this->movimientoRepository->getMovimientosConRelaciones($filtros);
    }

    public function obtenerMovimientoPorId(string|int $id)
    {
        return $this->movimientoRepository->getMovimientoConRelaciones($id);
    }
}