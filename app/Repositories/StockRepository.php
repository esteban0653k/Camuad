<?php

namespace App\Repositories;
use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Interfaces\StockInterface;

class StockRepository extends BaseRepository implements StockInterface
{
    public function __construct(Stock $stock)
    {
        parent::__construct($stock);
    }

    public function findByActivo(bool $activo)
    {
        return $this->model->where("activo", $activo)->get();
        
    }
    
    public function findFechaCompra(string $fecha)
    {
        return $this->model->whereDate("fecha_compra", $fecha)->get();
    }

   public function findLowStock()
    {
        return $this->model->whereColumn("cantidad", "<=", "cantidad_min_stock")->get();
    }
} 