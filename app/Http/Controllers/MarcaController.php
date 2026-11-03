<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MarcaService;
use App\Http\Requests\MarcaRequest;
use Illuminate\Http\Request;

class MarcaController extends Controller {
    protected MarcaService $marcaService;

    public function __construct(MarcaService $marcaService) {
        $this->marcaService = $marcaService;
    }

    public function index() {
        return response()->json(['success' => true, 'data' => $this->marcaService->listarMarcas()], 200);
    }

    public function store(MarcaRequest $request) {
        $marca = $this->marcaService->crearMarca($request->validated());
        return response()->json(['success' => true, 'message' => 'Marca creada exitosamente', 'data' => $marca], 201);
    }

    public function show($id) {
        $marca = $this->marcaService->obtenerMarcaPorId($id);
        if (!$marca) {
            return response()->json(['success' => false, 'message' => 'Marca no encontrada'], 404);
        }
        return response()->json(['success' => true, 'data' => $marca], 200);
    }

    public function update(MarcaRequest $request, $id) {
        $marca = $this->marcaService->actualizarMarca($id, $request->validated());
        if (!$marca) {
            return response()->json(['success' => false, 'message' => 'Marca no encontrada para actualizar'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Marca actualizada correctamente', 'data' => $marca], 200);
    }

    public function destroy($id) {
        $eliminado = $this->marcaService->eliminarMarca($id);
        if (!$eliminado) {
            return response()->json(['success' => false, 'message' => 'Marca no encontrada para eliminar'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Marca eliminada correctamente'], 200);
    }

    
    public function buscar(Request $request) {
        $nombre = $request->query('nombre', '');
        return response()->json(['success' => true, 'data' => $this->marcaService->buscarPorNombre($nombre)], 200);
    }

    public function conProductos() {
        return response()->json(['success' => true, 'data' => $this->marcaService->listarConProductos()], 200);
    }
}
