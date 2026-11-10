<?php

namespace App\Interfaces;

interface DetalleCompraInterface extends BaseInterface
{
    public function findByCompra(int $idCompra);
    public function findBySku(string $sku);
    public function findByCompraAndSku(int $idCompra, string $sku);
    public function findWithProducto(int $idCompra);
    public function sumSubtotalByCompra(int $idCompra);
    public function deleteByCompra(int $idCompra);
}
