<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FacturaService;
use App\Http\Requests\FacturaRequest;

class FacturaController extends Controller 
{
    public function __construct(private FacturaService $facturaService) 
    {
    }

    public function index() 
    {
        $registros = $this->facturaService->listarFacturas();

        return response()->json([
            'message' => 'Se listaron las facturas correctamente',
            'data'    => $registros
        ], 200);
    }

    public function store(FacturaRequest $request) 
    {
        $registroFactura = $this->facturaService->crearFacturaConDetalles($request->validated());

        return response()->json([
            'message'          => 'La factura se creó correctamente',
            'datosRegistrados' => $registroFactura
        ], 201);
    }

    public function show(string $id) 
    {
        $registro = $this->facturaService->obtenerFacturaPorId($id);

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

    public function update(FacturaRequest $request, string $id) 
    {
        $registroActualizado = $this->facturaService->actualizarFactura($id, $request->validated());

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
        $validar = $this->facturaService->eliminarFactura($id);

        if (!$validar) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'La factura se eliminó correctamente'
        ], 200);
    }
}