<?php

namespace App\Repositories;

use App\Interfaces\SolicitudStockInterface;
use App\Models\SolicitudStock;

class SolicitudStockRepository extends BaseRepository implements SolicitudStockInterface
{

    public function __construct(SolicitudStock $model)
    {
        parent::__construct($model);
    }
    public function findByProveedor($nitProveedor)
    {
        return SolicitudStock::where('nit_proveedor', $nitProveedor)->get();
    }

    public function findByPrioridad($prioridad)
    {
        return SolicitudStock::where('prioridad', $prioridad)->get();
    }

    public function findFechaSolicitud($fecha)
    {
        return SolicitudStock::whereDate('fecha_solicitud', $fecha)->get();
    }
}
