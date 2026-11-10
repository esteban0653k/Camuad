<?php

namespace App\Repositories;

use App\Models\DetalleVenta;
use App\Interfaces\DetalleVentaInterface;

class DetalleVentaRepository extends BaseRepository implements DetalleVentaInterface {

    public function __construct(DetalleVenta $model) {
        parent::__construct($model);
    }

    public function getDetallesPorVenta(int $idVenta) {
        return $this->model
            ->with('producto')
            ->where('id_venta', $idVenta)
            ->get();
    }

    public function getDetallesConProducto() {
        return $this->model->with('venta', 'producto')->get();
    }
}