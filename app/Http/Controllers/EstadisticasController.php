<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/** Expone las vistas SQL de las migraciones en una sola petición. */
class EstadisticasController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => [
            'ventas_vs_egresos' => DB::table('v_ventas_vs_egresos')->orderBy('mes')->get(),
            'mas_vendidos'      => DB::table('v_productos_mas_vendidos')->limit(10)->get(),
            'bodega_categoria'  => DB::table('v_valoracion_bodega')
                ->selectRaw('categoria, SUM(valor_total_item) AS valor')->groupBy('categoria')->get(),
            'ventas_metodo'     => DB::table('v_ventas')
                ->selectRaw('metodo_pago, COUNT(*) AS cantidad, SUM(total) AS total')->groupBy('metodo_pago')->get(),
            'compras_proveedor' => DB::table('historial_compras')
                ->selectRaw('nombre_proveedor, SUM(total_compra) AS total')->groupBy('nombre_proveedor')->get(),
            'usuarios_rol'      => DB::table('roles as r')
        ->leftJoin('usuarios as u', function ($j) {
        $j->on('u.role_id', '=', 'r.id')->whereNull('u.deleted_at');
        })
            ->whereNull('r.deleted_at')
         ->selectRaw('r.nombre AS nombre_rol, COUNT(u.id) AS total_usuarios')
            ->groupBy('r.id', 'r.nombre')
            ->get(),
        ]]);
    }
}