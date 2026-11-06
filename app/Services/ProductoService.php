<?php

namespace App\Services;

use App\Interfaces\ProductoInterface;
use Illuminate\Validation\ValidationException;

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
        
        if (isset($datos['stock']) && $datos['stock'] < 0) {
            throw ValidationException::withMessages([
                'stock' => ['El stock del producto no puede ser un número negativo.']
            ]);
        }

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

    public function verificarYDescontarStock(string $sku, int $cantidadSolicitada)
    {
        $producto = $this->productoRepository->getById($sku);

        if (!$producto) {
            throw new \Exception('Producto no encontrado.', 404);
        }

        if ($cantidadSolicitada > $producto->stock) {
            throw ValidationException::withMessages([
                'stock' => ["Stock insuficiente. Cantidad disponible en inventario: {$producto->stock}."]
            ]);
        }

        $nuevoStock = $producto->stock - $cantidadSolicitada;

        return $this->productoRepository->update($sku, [
            'stock' => $nuevoStock
        ]);
    }
}