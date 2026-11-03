<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ClienteService;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected ClienteService $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index()
    {
        $clientes = $this->clienteService->listarClientes();
        return response()->json([
            'success' => true,
            'data' => $clientes
        ], 200);
    }

    public function store(ClienteRequest $request)
    {
        // Los datos ya vienen validados gracias al Form Request
        $cliente = $this->clienteService->crearCliente($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado exitosamente',
            'data' => $cliente
        ], 201);
    }

    public function show($numero_documento)
    {
        $cliente = $this->clienteService->obtenerClientePorId($numero_documento);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $cliente
        ], 200);
    }

    public function update(ClienteRequest $request, $numero_documento)
    {
        $clienteActualizado = $this->clienteService->actualizarCliente($numero_documento, $request->validated());

        if (!$clienteActualizado) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar, cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'data' => $clienteActualizado
        ], 200);
    }

    public function destroy($numero_documento)
    {
        $eliminado = $this->clienteService->eliminarCliente($numero_documento);

        if (!$eliminado) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado para eliminar'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente'
        ], 200);
    }
    public function getNombre(Request $request)
    {
        $nombre = $request->query('nombre', '');
        $clientes = $this->clienteService->buscarClientesPorNombre($nombre);

        return response()->json([
            'success' => true,
            'data' => $clientes
        ], 200);
    }
}