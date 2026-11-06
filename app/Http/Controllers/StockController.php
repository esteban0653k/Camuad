<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StockService;
use App\Http\Requests\StockRequest;

class StockController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    public function index()
    {
        $registros = $this->stockService->getAll();

        return response()->json([
            'message' => "Se listó el stock correctamente",
            'data' => $registros
        ], 200);
    }

    public function store(StockRequest $request)
    {
        $registroStock = $this->stockService->create($request->validated());
             
        $this->stockService->procesarAlertasYSolicitudesStock();

        return response()->json([
            'message' => 'El stock se creó correctamente y se procesaron las alertas',
            'datosRegistrados' => $registroStock
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->stockService->getById($id);

        if (!$registro) {
            return response()->json([
                'message' => 'No se encontró el registro de stock con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó el registro correctamente',
            'data' => $registro
        ], 200);
    }

    public function update(StockRequest $request, string $id)
    {
        $registroActualizado = $this->stockService->update($id, $request->validated());

        if (!$registroActualizado) {
            return response()->json([
                'message' => 'No se encontró el registro de stock con ese ID'
            ], 404);
        }

        $this->stockService->procesarAlertasYSolicitudesStock();

        return response()->json([
            'message' => 'Se actualizó el registro correctamente',
            'data' => $registroActualizado
        ], 200);
    }

    public function destroy(string $id)
    {
        $validar = $this->stockService->delete($id);
        
        if (!$validar) {
            return response()->json([
                'message' => 'No se encontró el registro de stock con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'El registro de stock se eliminó correctamente',
        ], 200);
    }

    public function listarStockActivo()
    {
        $registros = $this->stockService->listarStockActivo();

        return response()->json([
            'message' => 'Se listó el stock activo correctamente',
            'data' => $registros
        ], 200);
    }

    public function verificarAlertasManual()
    {
        $itemsBajos = $this->stockService->procesarAlertasYSolicitudesStock();

        return response()->json([
            'message' => 'Verificación de stock bajo ejecutada correctamente',
            'data' => $itemsBajos
        ], 200);
    }
}