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
        return response()->json($this->service->listar());
    }

    public function store(UsuarioRequest $request): JsonResponse
    {
        $usuario = $this->service->crear($request->validated());
        return response()->json($usuario, 201);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = $this->service->obtener($id);
        return response()->json($usuario);
    }

    public function update(UsuarioRequest $request, int $id): JsonResponse
    {
        $usuario = $this->service->actualizar($id, $request->validated());
        return response()->json($usuario);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->eliminar($id);
        return response()->json(null, 204);
    }
}