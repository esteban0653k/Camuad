<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TipoMovimientoService;
use App\Http\Requests\TipoMovimientoRequest;

class TipoMovimientoController extends Controller
{
    public function __construct(private TipoMovimientoService $tipoMovimientoService)
    {
    }

    public function index()
    {
        return response()->json([
            'message' => 'Se listaron los tipos de movimiento correctamente',
            'data'    => $this->tipoMovimientoService->listarTipos()
        ], 200);
    }

    public function store(TipoMovimientoRequest $request)
    {
        $registro = $this->tipoMovimientoService->crearTipo($request->validated());

        return response()->json([
            'message'          => 'El tipo de movimiento se creó correctamente',
            'datosRegistrados' => $registro
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->tipoMovimientoService->obtenerTipoPorId($id);

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

    public function update(TipoMovimientoRequest $request, string $id)
    {
        $registro = $this->tipoMovimientoService->actualizarTipo($id, $request->validated());

        if (!$registro) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'Se actualizó el registro correctamente',
            'data'    => $registro
        ], 200);
    }

    public function destroy(string $id)
    {
        $validar = $this->tipoMovimientoService->eliminarTipo($id);

        if (!$validar) {
            return response()->json([
                'message' => 'Manito no se encontró el registro con ese id'
            ], 404);
        }

        return response()->json([
            'message' => 'El tipo de movimiento se eliminó correctamente'
        ], 200);
    }
}