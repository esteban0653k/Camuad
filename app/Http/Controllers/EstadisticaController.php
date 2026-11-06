<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstadisticaRequest; 
use App\Services\EstadisticaService;

class EstadisticaController extends Controller
{
    public function __construct(private EstadisticaService $estadisticaService)
    {
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->estadisticaService->listarEstadisticas()
        ], 200);
    }

    public function store(EstadisticaRequest $request)
    {
        $estadistica = $this->estadisticaService->crearEstadistica($request->validated());
        return response()->json([
            'message' => 'Estadística creada correctamente',
            'data' => $estadistica
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => $this->estadisticaService->obtenerEstadisticaPorId($id)
        ], 200);
    }

    public function update(EstadisticaRequest $request, $id)
    {
        $estadistica = $this->estadisticaService->actualizarEstadistica($id, $request->validated());
        return response()->json([
            'message' => 'Estadística actualizada correctamente',
            'data' => $estadistica
        ], 200);
    }

    public function destroy($id)
    {
        $this->estadisticaService->eliminarEstadistica($id);
        return response()->json([
            'message' => 'Estadística eliminada correctamente'
        ], 200);
    }

    public function chartData()
    {
        return response()->json(
            $this->estadisticaService->generarFormatoChartJs(), 
            200
        );
    }
}