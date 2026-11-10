<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DetalleCompraService;
use App\Services\CompraProveedorService;
use App\Http\Requests\DetalleCompraRequest;

class DetalleCompraController extends Controller
{
    public function __construct(
        private DetalleCompraService $detalleService,
        private CompraProveedorService $compraService
    ) {
    }

    public function index()
    {
        $registros = $this->detalleService->getAll();

        return response()->json([
            'message' => 'Se listaron los detalles de compra correctamente',
            'data' => $registros
        ], 200);
    }

    public function store(DetalleCompraRequest $request)
    {
        $registroDetalle = $this->detalleService->create($request->validated());

        $this->compraService->recalcularTotal($registroDetalle->id_compra);

        return response()->json([
            'message' => 'El detalle se creó correctamente y se actualizó el total de la compra',
            'datosRegistrados' => $registroDetalle
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->detalleService->getById($id);

        if (!$registro) {
            return response()->json([
                'message' => 'No se encontró el detalle de compra con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó el detalle correctamente',
            'data' => $registro
        ], 200);
    }

    public function update(DetalleCompraRequest $request, string $id)
    {
        $detalleActual = $this->detalleService->getById($id);

        if (!$detalleActual) {
            return response()->json([
                'message' => 'No se encontró el detalle de compra con ese ID'
            ], 404);
        }

        $idCompraAnterior = $detalleActual->id_compra;

        $registroActualizado = $this->detalleService->update($id, $request->validated());

        $this->compraService->recalcularTotal($idCompraAnterior);

        // Si el detalle se movió a otra compra, también se recalcula la nueva
        $nuevaCompra = $request->validated()['id_compra'] ?? null;
        if ($nuevaCompra && (int) $nuevaCompra !== (int) $idCompraAnterior) {
            $this->compraService->recalcularTotal((int) $nuevaCompra);
        }

        return response()->json([
            'message' => 'Se actualizó el detalle correctamente y se actualizó el total de la compra',
            'data' => $registroActualizado
        ], 200);
    }

    public function destroy(string $id)
    {
        $detalleActual = $this->detalleService->getById($id);

        if (!$detalleActual) {
            return response()->json([
                'message' => 'No se encontró el detalle de compra con ese ID'
            ], 404);
        }

        $idCompra = $detalleActual->id_compra;

        $this->detalleService->delete($id);

        $this->compraService->recalcularTotal($idCompra);

        return response()->json([
            'message' => 'El detalle se eliminó correctamente y se actualizó el total de la compra',
        ], 200);
    }

    public function listarPorCompra(int $idCompra)
    {
        $registros = $this->detalleService->listarPorCompra($idCompra);

        return response()->json([
            'message' => 'Se listaron los detalles de la compra correctamente',
            'data' => $registros
        ], 200);
    }

    public function listarPorSku(string $sku)
    {
        $registros = $this->detalleService->listarPorSku($sku);

        return response()->json([
            'message' => 'Se listaron los detalles del producto correctamente',
            'data' => $registros
        ], 200);
    }
}