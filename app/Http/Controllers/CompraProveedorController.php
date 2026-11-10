<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompraProveedorService;
use App\Http\Requests\CompraProveedorRequest;

class CompraProveedorController extends Controller
{
    public function __construct(private CompraProveedorService $compraService)
    {
    }

    public function index()
    {
        $registros = $this->compraService->getAll();

        return response()->json([
            'message' => 'Se listaron las compras correctamente',
            'data' => $registros
        ], 200);
    }

    public function store(CompraProveedorRequest $request)
    {
        $registroCompra = $this->compraService->create($request->validated());

        return response()->json([
            'message' => 'La compra se creó correctamente',
            'datosRegistrados' => $registroCompra
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->compraService->getById($id);

        if (!$registro) {
            return response()->json([
                'message' => 'No se encontró la compra con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó la compra correctamente',
            'data' => $registro
        ], 200);
    }

    public function update(CompraProveedorRequest $request, string $id)
    {
        $registroActualizado = $this->compraService->update($id, $request->validated());

        if (!$registroActualizado) {
            return response()->json([
                'message' => 'No se encontró la compra con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'Se actualizó la compra correctamente',
            'data' => $registroActualizado
        ], 200);
    }

    public function destroy(string $id)
    {
        $validar = $this->compraService->delete($id);

        if (!$validar) {
            return response()->json([
                'message' => 'No se encontró la compra con ese ID'
            ], 404);
        }

        return response()->json([
            'message' => 'La compra se eliminó correctamente',
        ], 200);
    }

    public function listarPendientes()
    {
        $registros = $this->compraService->listarPendientes();

        return response()->json([
            'message' => 'Se listaron las compras pendientes correctamente',
            'data' => $registros
        ], 200);
    }

    public function listarPorEstado(string $estado)
    {
        $registros = $this->compraService->listarPorEstado($estado);

        return response()->json([
            'message' => 'Se listaron las compras por estado correctamente',
            'data' => $registros
        ], 200);
    }

    public function listarPorProveedor(string $nitProveedor)
    {
        $registros = $this->compraService->listarPorProveedor($nitProveedor);

        return response()->json([
            'message' => 'Se listaron las compras del proveedor correctamente',
            'data' => $registros
        ], 200);
    }

    public function obtenerConDetalles(int $id)
    {
        $registro = $this->compraService->obtenerConDetalles($id);

        return response()->json([
            'message' => 'Se listó la compra con sus detalles correctamente',
            'data' => $registro
        ], 200);
    }
}