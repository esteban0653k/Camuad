<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\TipoMovimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReposicionController extends Controller
{
    public function __invoke(Request $request, string $sku): JsonResponse
    {
        $data = $request->validate(['cantidad' => 'required|integer|min:1|max:100000']);

        $producto = DB::transaction(function () use ($sku, $data) {
            $p = Producto::where('sku', $sku)->lockForUpdate()->firstOrFail();
            $p->stock += $data['cantidad'];
            $p->estado = 'activo';
            $p->save();

            $tipo = TipoMovimiento::firstOrCreate(
                ['nombre' => 'Entrada'],
                ['descripcion' => 'Ingreso de mercancía al inventario']
            );
            Movimiento::create([
                'fecha_movimiento'   => now(),
                'cantidad'           => $data['cantidad'],
                'estado'             => 'activo',
                'id_tipo_movimiento' => $tipo->id_tipo_movimiento,
                'sku_producto'       => $p->sku,
            ]);
            return $p;
        });

        return response()->json(['message' => 'Stock repuesto correctamente.', 'data' => $producto]);
    }
}