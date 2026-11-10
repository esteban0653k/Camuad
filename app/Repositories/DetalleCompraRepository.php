<?php

namespace App\Repositories;

use App\Models\DetalleCompra;
use App\Interfaces\DetalleCompraInterface;

class DetalleCompraRepository extends BaseRepository implements DetalleCompraInterface
{
    public function __construct(DetalleCompra $detalleCompra)
    {
        parent::__construct($detalleCompra);
    }

    public function findByCompra(int $idCompra)
    {
        return $this->model->where("id_compra", $idCompra)->get();
    }

    public function findBySku(string $sku)
    {
        return $this->model->where("sku_producto", $sku)->get();
    }

    public function findByCompraAndSku(int $idCompra, string $sku)
    {
        return $this->model
            ->where("id_compra", $idCompra)
            ->where("sku_producto", $sku)
            ->first();
    }

    public function findWithProducto(int $idCompra)
    {
        return $this->model
            ->with("producto")
            ->where("id_compra", $idCompra)
            ->get();
    }

    public function sumSubtotalByCompra(int $idCompra)
    {
        return $this->model->where("id_compra", $idCompra)->sum("subtotal");
    }

    public function deleteByCompra(int $idCompra)
    {
        return $this->model->where("id_compra", $idCompra)->delete();
    }
}