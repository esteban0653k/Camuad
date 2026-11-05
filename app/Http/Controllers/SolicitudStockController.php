<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudStockRequest;
use App\Services\SolicitudStockService;
use Illuminate\Http\JsonResponse;

class SolicitudStockController extends Controller
{
    protected SolicitudStockService $solicitudStockService;

    public function __construct(SolicitudStockService $solicitudStockService)
    {
        $this->solicitudStockService = $solicitudStockService;
    }

    public function index(): JsonResponse
    {
        $solicitudes = $this->solicitudStockService->getAll();
        return response()->json($solicitudes, 200);
    }

    public function store(SolicitudStockRequest $request): JsonResponse
    {
        $solicitud = $this->solicitudStockService->create($request->validated());
        return response()->json([
            'message' => 'Solicitud de stock creada exitosamente.',
            'data' => $solicitud
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $solicitud = $this->solicitudStockService->getById($id);
        return response()->json($solicitud, 200);
    }

    public function update(SolicitudStockRequest $request, string $id): JsonResponse
    {
        $solicitud = $this->solicitudStockService->update($id, $request->validated());
        return response()->json([
            'message' => 'Solicitud de stock actualizada exitosamente.',
            'data' => $solicitud
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->solicitudStockService->delete($id);
        return response()->json([
            'message' => 'Solicitud de stock eliminada correctamente.'
        ], 200);
    }
}