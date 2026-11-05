<?php

namespace App\Repositories;

use App\Models\Producto;
use App\Interfaces\ProductoInterface;

class ProductoRepository extends BaseRepository implements ProductoInterface
{
    public function __construct(Producto $model)
    {
        parent::__construct($model);
    }

    public function buscarPorNombre(string $nombre)
    {
        return $this->model->with(['categoria', 'marca'])->where('nombre_producto', 'LIKE', "%{$nombre}%")->get();
    }

    public function obtenerProductosConRelaciones()
    {
        return $this->model->with(['categoria', 'marca'])->get();
    }
}