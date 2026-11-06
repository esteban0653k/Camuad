<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    protected ProductoService $productoService;

    public function __construct(ProductoService $productoService)
    {
        $this->productoService = $productoService;
    }

    public function index(): JsonResponse
    {
        $productos = $this->productoService->listarProductos();

        return response()->json([
            'success' => true,
            'data' => $productos
        ], 200);
    }

    public function store(ProductoRequest $request): JsonResponse
    {
        $producto = $this->productoService->crearProducto($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'data' => $producto
        ], 201);
    }

    public function show(string $sku): JsonResponse
    {
        $producto = $this->productoService->obtenerProductoPorId($sku);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $producto
        ], 200);
    }

    public function update(ProductoRequest $request, string $sku): JsonResponse
    {
        $actualizado = $this->productoService->actualizarProducto($sku, $request->validated());

        if (!$actualizado) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto = $this->productoService->obtenerProductoPorId($sku);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto
        ], 200);
    }

    public function destroy(string $sku): JsonResponse
    {
        $eliminado = $this->productoService->eliminarProducto($sku);

        if (!$eliminado) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ], 200);
    }

    public function buscarPorNombre(Request $request): JsonResponse
    {
        $nombre = $request->query('nombre', '');

        $productos = $this->productoService->buscarPorNombre($nombre);

        return response()->json([
            'success' => true,
            'data' => $productos
        ], 200);
    }
    public function descontarStock(Request $request, string $sku): JsonResponse
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ], [
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.'
        ]);

        try {
            $productoActualizado = $this->productoService->verificarYDescontarStock($sku, (int) $request->input('cantidad'));

            return response()->json([
                'success' => true,
                'message' => 'Stock descontado exitosamente.',
                'data' => $productoActualizado
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 404);
        }
    }
}