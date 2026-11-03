<?php

namespace App\Services;

use App\Interfaces\MarcaInterface;

class MarcaService {
    protected MarcaInterface $marcaRepository;

    public function __construct(MarcaInterface $marcaRepository) {
        $this->marcaRepository = $marcaRepository;
    }

    public function listarMarcas() {
        return $this->marcaRepository->getAll();
    }

    public function crearMarca(array $data) {
        return $this->marcaRepository->create($data);
    }

    public function obtenerMarcaPorId($id) {
        return $this->marcaRepository->getById($id);
    }

    public function actualizarMarca($id, array $data) {
        return $this->marcaRepository->update($id, $data);
    }

    public function eliminarMarca($id) {
        return $this->marcaRepository->delete($id);
    }

    public function buscarPorNombre(string $nombre) {
        return $this->marcaRepository->findByNombre($nombre);
    }

    public function verificarSiExiste(string $nombre): bool {
        return $this->marcaRepository->existeNombre($nombre);
    }

    public function listarConProductos() {
        return $this->marcaRepository->getMarcasConProductos();
    }
}