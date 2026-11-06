<?php

namespace App\Services;

use App\Interfaces\ReporteInterface;

class ReporteService
{
    public function __construct(private ReporteInterface $reporteRepository)
    {
    }

    public function listarReportes()
    {
        return $this->reporteRepository->getAll();
    }

    public function obtenerReportePorId(string|int $id)
    {
        return $this->reporteRepository->getById($id);
    }

    public function crearReporte(array $data)
    {
        return $this->reporteRepository->create($data);
    }

    public function actualizarReporte(string|int $id, array $data)
    {
        return $this->reporteRepository->update($id, $data);
    }

    public function eliminarReporte(string|int $id)
    {
        return $this->reporteRepository->delete($id);
    }
}