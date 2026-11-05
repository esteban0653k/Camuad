<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Interfaces\StockInterface;

class StockRepository extends BaseRepository implements StockInterface
{
    public function __construct(Stock $stock)
    {
        parent::__construct($stock);
    }

    public function findByActivo(bool $activo)
    {
        $estadoBusqueda = $activo ? 'activo' : 'inactivo';

        return $this->model->where("estado", $estadoBusqueda)->get();
    }
    
    public function findFechaCompra(string $fecha)
    {
        return $this->model->whereDate("fecha_compra", $fecha)->get();
    }

    public function findLowStock()
    {
        return $this->model->whereColumn("cantidad", "<=", "cantidad_min_stock")->get();
    }

    public function findLowStockUnnotified()
    {
        return $this->model
            ->whereColumn("cantidad", "<=", "cantidad_min_stock")
            ->where("notificado", false)
            ->get();
    }
}