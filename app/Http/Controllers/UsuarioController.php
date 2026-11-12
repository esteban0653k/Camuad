<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
    public function __construct(
        protected UsuarioService $service
    ) {}

    public function index(): JsonResponse
    {
        $usuarios = $this->service->listar();

        return response()->json([
            'success' => true,
            'message' => 'Listado de usuarios obtenido correctamente.',
            'data' => $usuarios
        ]);
    }

    public function store(UsuarioRequest $request): JsonResponse
    {
        $usuario = $this->service->crear($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente.',
            'data' => $usuario
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = $this->service->obtener($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario obtenido correctamente.',
            'data' => $usuario
        ]);
    }

    public function update(UsuarioRequest $request, int $id): JsonResponse
    {
        $usuario = $this->service->actualizar($id, $request->validated());

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado para actualizar.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente.',
            'data' => $usuario
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $eliminado = $this->service->eliminar($id);

        if (!$eliminado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado para eliminar.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente.'
        ], 204); 
    }
}