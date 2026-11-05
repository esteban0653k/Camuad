<?php

namespace App\Repositories;

use App\Models\DetalleVenta;
use App\Interfaces\DetalleVentaInterface;

class DetalleVentaRepository extends BaseRepository implements DetalleVentaInterface {
    
    public function __construct(DetalleVenta $model) {
        parent::__construct($model);
    }
}