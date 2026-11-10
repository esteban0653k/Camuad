<?php

namespace App\Services;

use App\Interfaces\ProductoInterface;
use Exception;

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

    public function obtenerProductoPorId(string|int $sku)
    {
        return $this->productoRepository->getById($sku);
    }

    public function crearProducto(array $datos)
    {
        return $this->productoRepository->create($datos);
    }

    public function actualizarProducto(string|int $sku, array $datos)
    {
        return $this->productoRepository->update($sku, $datos);
    }

    public function eliminarProducto(string|int $sku)
    {
        return $this->productoRepository->delete($sku);
    }

    public function buscarPorNombre(string $nombre)
    {
        return $this->productoRepository->buscarPorNombre($nombre);
    }
 
    public function descontarStock(string|int $sku, int $cantidad)
    {
        $producto = $this->productoRepository->getById($sku);

        if (!$producto) {
            throw new Exception("Producto no encontrado con el SKU: {$sku}", 404);
        }

        if ($producto->stock < $cantidad) {
            throw new Exception("Stock insuficiente. Stock actual: {$producto->stock}", 422);
        }

        $nuevoStock = $producto->stock - $cantidad;
        
        $datosActualizacion = [
            'stock' => $nuevoStock,
        ];

        if ($nuevoStock === 0) {
            $datosActualizacion['estado'] = 'inactivo';
        }

        return $this->productoRepository->update($sku, $datosActualizacion);
    }


    public function reabastecerStock(string|int $sku, int $cantidad)
    {
        $producto = $this->productoRepository->getById($sku);

        if (!$producto) {
            throw new Exception("Producto no encontrado con el SKU: {$sku}", 404);
        }

        $nuevoStock = $producto->stock + $cantidad;

        $datosActualizacion = [
            'stock' => $nuevoStock,
            'estado' => 'activo' 
        ];

        return $this->productoRepository->update($sku, $datosActualizacion);
    }
}
