<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriasRequest;
use App\Services\CategoriasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriasController extends Controller

{
    protected CategoriasService $categoriasService;

    public function __construct(CategoriasService $categoriasService)
    {
        $this->categoriasService = $categoriasService;
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->has('nombre')) {
            $categorias = $this->categoriasService->buscarPorNombre($request->query('nombre'));
        } else {
            $categorias = $this->categoriasService->listarCategorias();
        }

        return response()->json([
            'success' => true,
            'data' => $categorias
        ], 200);
    }

    public function store(CategoriasRequest $request): JsonResponse
    {
        $categoria = $this->categoriasService->crearCategoria($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Categoría creada exitosamente',
            'data' => $categoria
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $categoria = $this->categoriasService->obtenerCategoriaPorId($id);
        
        if (!$categoria) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $categoria
        ], 200);
    }

    public function update(CategoriasRequest $request, int $id): JsonResponse
    {
        $actualizado = $this->categoriasService->actualizarCategoria($id, $request->validated());

        if (!$actualizado) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada o no se pudo actualizar'
            ], 404);
        }

        $categoria = $this->categoriasService->obtenerCategoriaPorId($id);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada exitosamente',
            'data' => $categoria
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $eliminado = $this->categoriasService->eliminarCategoria($id);

        if (!$eliminado) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada exitosamente'
        ], 200);
    }

    public function conProductos(): JsonResponse
    {
        $categorias = $this->categoriasService->obtenerCategoriasConProductos();
        return response()->json([
            'success' => true,
            'data' => $categorias
        ], 200);
    }
}