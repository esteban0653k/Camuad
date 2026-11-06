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
        return $this->model->where('nit_proveedor', $nitProveedor)->get();
    }

    public function findByPrioridad($prioridad)
    {
        return $this->model->where('prioridad', $prioridad)->get();
    }

    public function findFechaSolicitud($fecha)
    {
        return $this->model->whereDate('fecha_solicitud', $fecha)->get();
    }
}