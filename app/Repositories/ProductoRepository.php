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

    public function getById(string|int $sku)
    {
        return $this->model->with(['categoria', 'marca', 'proveedor'])
            ->where('sku', $sku)
            ->first();
    }

    public function update(string|int $sku, array $datos)
    {
        $producto = $this->getById($sku);

        if (!$producto) {
            return null;
        }

        $producto->update($datos);

        return $producto->fresh(['categoria', 'marca', 'proveedor']);
    }

    public function buscarPorNombre(string $nombre)
    {
        return $this->model->with(['categoria', 'marca', 'proveedor'])
            ->where('nombre_producto', 'LIKE', "%{$nombre}%")
            ->get();
    }

    public function obtenerProductosConRelaciones()
    {
        return $this->model->with(['categoria', 'marca', 'proveedor'])
            ->get();
    }
}