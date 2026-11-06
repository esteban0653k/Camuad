<?php

namespace App\Repositories;

use App\Interfaces\EstadisticaInterface;
use App\Models\Estadistica; 

class EstadisticaRepository extends BaseRepository implements EstadisticaInterface
{
    public function __construct(Estadistica $model)
    {
        parent::__construct($model);
    }

    public function obtenerDatosParaChartJs()
    {
        // Excluimos los registros eliminados lógicamente (SoftDeletes)
        $estadisticas = Estadistica::whereNull('deleted_at')->get();

        return [
            'labels' => $estadisticas->pluck('tipo_estadistica'),
            'datasets' => [
                [
                    'label' => 'Métrica de Stock / Registros',
                    'data' => $estadisticas->pluck('stock'),
                    'backgroundColor' => ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF']
                ]
            ]
        ];
    }
}