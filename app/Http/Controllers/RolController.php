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
        return response()->json($this->service->listar());
    }

    public function store(RolRequest $request): JsonResponse
    {
        $rol = $this->service->crear($request->validated());
        return response()->json($rol, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->obtener($id));
    }

    public function update(RolRequest $request, int $id): JsonResponse
    {
        return response()->json($this->service->actualizar($id, $request->validated()));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->eliminar($id);
        return response()->json(null, 204);
    }
}