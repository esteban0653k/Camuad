<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\VentaService;
use App\Http\Requests\VentaRequest;

class VentaController extends Controller
{
    public function __construct(private VentaService $ventaService)
    {
    }

    public function index()
    {
        $registros = $this->ventaService->listarVentas();

        return response()->json([
            'message' => 'Se listaron las ventas correctamente',
            'data'    => $registros
        ], 200);
    }

    public function store(VentaRequest $request)
    {
        $registroVenta = $this->ventaService->crearVentaConDetalles($request->validated());

        return response()->json([
            'message'          => 'La venta se creó correctamente',
            'datosRegistrados' => $registroVenta
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->ventaService->obtenerVentaPorId($id);

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

    public function update(VentaRequest $request, string $id)
    {
        $registroActualizado = $this->ventaService->actualizarVenta($id, $request->validated());

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
        $validar = $this->ventaService->eliminarVenta($id);

        if (!$validar) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'La venta se eliminó correctamente'
        ], 200);
    }
}