<?php

namespace App\Interfaces;

interface DetalleVentaInterface extends BaseInterface {
    public function getDetallesPorVenta(int $idVenta);
    public function getDetallesConProducto();
}