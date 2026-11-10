<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MovimientoService;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function __construct(private MovimientoService $movimientoService)
    {
    }

    public function index(Request $request)
    {
        $registros = $this->movimientoService->listarMovimientos(
            $request->only(['sku_producto', 'id_tipo_movimiento', 'id_venta', 'id_compra', 'desde', 'hasta'])
        );

        return response()->json([
            'message' => 'Se listaron los movimientos correctamente',
            'data'    => $registros
        ], 200);
    }

    public function show(string $id)
    {
        $registro = $this->movimientoService->obtenerMovimientoPorId($id);

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
}