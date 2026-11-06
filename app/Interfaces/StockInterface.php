<?php

namespace App\Interfaces;

interface StockInterface extends BaseInterface
{
    public function findByActivo(bool $activo);
    public function findFechaCompra(string $fecha);
    public function findLowStock();
    public function findLowStockUnnotified();
}   