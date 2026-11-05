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

    public function obtenerProductoPorId(int $id)
    {
        return $this->productoRepository->getById($id);
    }

    public function crearProducto(array $datos)
    {
        return $this->productoRepository->create($datos);
    }

    public function actualizarProducto(int $id, array $datos)
    {
        return $this->productoRepository->update($id, $datos);
    }

    public function eliminarProducto(int $id)
    {
        return $this->productoRepository->delete($id);
    }
}