<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DetalleVentaService;
use App\Http\Requests\DetalleVentaRequest;

class DetalleVentaController extends Controller 
{
    public function __construct(private DetalleVentaService $detalleVentaService) 
    {
    }

    public function index() 
    {
        $registros = $this->detalleVentaService->listarDetalles();

        return response()->json([
            'message' => 'Se listaron los detalles de venta correctamente',
            'data'    => $registros
        ], 200);
    }

    public function store(DetalleVentaRequest $request) 
    {
        $registroDetalle = $this->detalleVentaService->crearDetalle($request->validated());

        return response()->json([
            'message'          => 'El detalle de venta se creó correctamente',
            'datosRegistrados' => $registroDetalle
        ], 201);
    }

    public function show(string $id) 
    {
        $registro = $this->detalleVentaService->obtenerDetallePorId($id);

        if (!$registro) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó el registro correctamente',
            'data'    => $registro
        ], 200);
    }

    public function update(DetalleVentaRequest $request, string $id) 
    {
        $registroActualizado = $this->detalleVentaService->actualizarDetalle($id, $request->validated());

        if (!$registroActualizado) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'Se actualizó el registro correctamente',
            'data'    => $registroActualizado
        ], 200);
    }

    public function destroy(string $id) 
    {
        $validar = $this->detalleVentaService->eliminarDetalle($id);

        if (!$validar) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'El detalle de venta se eliminó correctamente'
        ], 200);
    }
}