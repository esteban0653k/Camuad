<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ClienteService;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $clienteService)
    {
    }

    public function index(): JsonResponse
    {
        $clientes = $this->clienteService->listarClientes();

        return response()->json([
            'message' => 'Se listaron los clientes correctamente',
            'data'    => $clientes
        ], 200);
    }

    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = $this->clienteService->crearCliente($request->validated());

        return response()->json([
            'message' => 'El cliente se creó correctamente',
            'data'    => $cliente
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $cliente = $this->clienteService->obtenerClientePorId($id);

        if (!$cliente) {
            return response()->json([
                'message' => 'No se encontró el cliente con ese número de documento'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó el cliente correctamente',
            'data'    => $cliente
        ], 200);
    }


    public function update(ClienteRequest $request, string $id): JsonResponse
    {
        $clienteActualizado = $this->clienteService->actualizarCliente($id, $request->validated());

        if (!$clienteActualizado) {
            return response()->json([
                'message' => 'No se encontró el cliente con ese número de documento'
            ], 404);
        }

        return response()->json([
            'message' => 'Se actualizó el cliente correctamente',
            'data'    => $clienteActualizado
        ], 200);
    }


    public function destroy(string $id): JsonResponse
    {
        $validar = $this->clienteService->eliminarCliente($id);

        if (!$validar) {
            return response()->json([
                'message' => 'No se encontró el cliente con ese número de documento'
            ], 404);
        }

        return response()->json([
            'message' => 'El cliente se eliminó correctamente',
        ], 200);
    }

    
    public function getNombre(Request $request): JsonResponse
    {
        $nombre = $request->query('nombre', '');
        $clientes = $this->clienteService->buscarClientesPorNombre($nombre);

        return response()->json([
            'message' => 'Resultados de la búsqueda',
            'data'    => $clientes
        ], 200);
    }
}