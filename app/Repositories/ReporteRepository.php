<?php

namespace App\Repositories;

use App\Interfaces\ReporteInterface;
use App\Models\Reporte;

class ReporteRepository extends BaseRepository implements ReporteInterface
{
    public function __construct(Reporte $model)
    {
        parent::__construct($model);
    }
}