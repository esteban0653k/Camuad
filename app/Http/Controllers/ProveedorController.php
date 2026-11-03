<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProveedorService;
use App\Http\Requests\ProveedorRequest;

class ProveedorController extends Controller
{
    public function __construct(private ProveedorService $proveedorService)
    {
    }

    public function index()
    {
        $registros = $this->proveedorService->getAll();

        return response()->json([
            'message'  => "Se listaron los proveedores correctamente",
            'data' => $registros
        ], 200);
    }

    public function store(RequestProveedor $request)
    {
        $registroProveedor = $this->proveedorService->create($request->validated());
             
        return response()->json([
            'message' => 'El proveedor se creó correctamente',
            'datosRegistrados' => $registroProveedor
        ], 201);
    }

    public function show(string $id)
    {
        $registro = $this->proveedorService->getById($id);

        if (!$registro) {
            return response()->json([
                'message' => 'No se encontró el registro con ese nit'
            ], 404);
        }

        return response()->json([
            'message' => 'Se listó el registro correctamente',
            'data' => $registro
        ], 200);
    }

    public function update(RequestProveedor $request, string $id)
    {
        $registroActualizado = $this->proveedorService->update($id, $request->validated());

        if (!$registroActualizado) {
            return response()->json([
                'message' => 'No se encontró el registro con ese nit'
            ], 404);
        }

        return response()->json([
            'message' => 'Se actualizó el registro correctamente',
            'data' => $registroActualizado
        ], 200);
    }

    public function destroy(string $id)
    {
        $validar = $this->proveedorService->delete($id);
        
        if (!$validar) {
            return response()->json([
                'message' => 'No se encontró el registro con ese nit'
            ], 404);
        }

        return response()->json([
            'message' => 'El proveedor se eliminó correctamente',
        ], 200);
    }

    public function findByName(string $name)
    {
        $registros = $this->proveedorService->findByName($name);

        return response()->json([
            'message' => 'Se listó correctamente por nombre',
            'data' => $registros
        ], 200);
    }

    public function findByCorreo(string $correo)
    {
        $registros = $this->proveedorService->findByCorreo($correo);
        
        return response()->json([
            'message' => 'Se listó correctamente por correo',
            'data' => $registros
        ], 200);
    }
}
