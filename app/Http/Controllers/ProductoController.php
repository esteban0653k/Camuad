<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function show(int $id): JsonResponse
    {
        $producto = $this->productoService->obtenerProductoPorId($id);
        
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

    public function update(ProductoRequest $request, int $id): JsonResponse
    {
        $actualizado = $this->productoService->actualizarProducto($id, $request->validated());

        if (!$actualizado) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto = $this->productoService->obtenerProductoPorId($id);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $eliminado = $this->productoService->eliminarProducto($id);

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
}