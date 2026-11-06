<?php

namespace App\Services;

use App\Interfaces\EstadisticaInterface;

class EstadisticaService
{
    public function __construct(private EstadisticaInterface $estadisticaRepository)
    {
    }

    public function listarEstadisticas()
    {
        return $this->estadisticaRepository->getAll();
    }

    public function obtenerEstadisticaPorId(string|int $id)
    {
        return $this->estadisticaRepository->getById($id);
    }

    public function crearEstadistica(array $data)
    {
        $data['fecha_generacion'] = now();
        return $this->estadisticaRepository->create($data);
    }

    public function actualizarEstadistica(string|int $id, array $data)
    {
        return $this->estadisticaRepository->update($id, $data);
    }

    public function eliminarEstadistica(string|int $id)
    {
        return $this->estadisticaRepository->delete($id);
    }

    public function generarFormatoChartJs()
    {
        return $this->estadisticaRepository->obtenerDatosParaChartJs();
    }
}