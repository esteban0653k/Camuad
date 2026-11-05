<?php

namespace App\Services;

use App\Interfaces\ProductoInterface;

class ProductoService
{
    protected ProductoInterface $productoRepository;

    public function __construct(ProductoInterface $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    public function listarProductos()
    {
        return $this->productoRepository->obtenerProductosConRelaciones();
    }

    public function obtenerProductoPorId(string $sku)
    {
        return $this->productoRepository->getById($sku);
    }

    public function crearProducto(array $datos)
    {
        return $this->productoRepository->create($datos);
    }

    public function actualizarProducto(string $sku, array $datos)
    {
        return $this->productoRepository->update($sku, $datos);
    }

    public function eliminarProducto(string $sku)
    {
        return $this->productoRepository->delete($sku);
    }
    
    public function buscarPorNombre(string $nombre)
    {
        return $this->productoRepository->buscarPorNombre($nombre);
    }
}