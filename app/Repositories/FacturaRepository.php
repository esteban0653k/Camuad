<?php

namespace App\Repositories;

use App\Models\Factura;
use App\Interfaces\FacturaInterface;

class FacturaRepository extends BaseRepository implements FacturaInterface {
    
    public function __construct(Factura $model) {
        parent::__construct($model);
    }

    public function getFacturasConCliente() {
        return $this->model->with('cliente', 'detalles')->get();
    }
}