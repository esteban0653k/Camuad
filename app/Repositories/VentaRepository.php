<?php

namespace App\Repositories;

use App\Models\Venta;
use App\Interfaces\VentaInterface;

class VentaRepository extends BaseRepository implements VentaInterface {

    public function __construct(Venta $model) {
        parent::__construct($model);
    }

    public function getVentasConCliente() {
        return $this->model->with('cliente', 'detalles')->get();
    }
}