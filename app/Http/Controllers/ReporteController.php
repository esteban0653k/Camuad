<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReporteRequest;
use App\Services\ReporteService;

class ReporteController extends Controller
{
    public function __construct(private ReporteService $reporteService)
    {
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->reporteService->listarReportes()
        ], 200);
    }

    public function store(ReporteRequest $request)
    {
        $reporte = $this->reporteService->crearReporte($request->validated());
        return response()->json([
            'message' => 'Reporte creado correctamente',
            'data' => $reporte
        ], 201);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => $this->reporteService->obtenerReportePorId($id)
        ], 200);
    }

    public function update(ReporteRequest $request, $id)
    {
        $reporte = $this->reporteService->actualizarReporte($id, $request->validated());
        return response()->json([
            'message' => 'Reporte actualizado correctamente',
            'data' => $reporte
        ], 200);
    }

    public function destroy($id)
    {
        $this->reporteService->eliminarReporte($id);
        return response()->json([
            'message' => 'Reporte eliminado correctamente'
        ], 200);
    }
}