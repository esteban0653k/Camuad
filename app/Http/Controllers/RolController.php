<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolRequest;
use App\Services\RolService;
use Illuminate\Http\JsonResponse;

class RolController extends Controller
{
    public function __construct(
        protected RolService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Roles obtenidos correctamente.',
            'data'    => $this->service->listar(),
        ]);
    }

    public function store(RolRequest $request): JsonResponse
    {
        $rol = $this->service->crear($request->validated());

        return response()->json([
            'message' => 'Rol creado correctamente.',
            'data'    => $rol,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Rol obtenido correctamente.',
            'data'    => $this->service->obtener($id),
        ]);
    }

    public function update(RolRequest $request, int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Rol actualizado correctamente.',
            'data'    => $this->service->actualizar($id, $request->validated()),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->eliminar($id);

        return response()->json([
            'message' => 'Rol eliminado correctamente.',
        ]);
    }
}