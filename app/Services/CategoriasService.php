<?php

namespace App\Services;

use App\Interfaces\CategoriasInterface;
use Illuminate\Support\Str;

class CategoriasService
{
    protected CategoriasInterface $categoriasRepository;

    public function __construct(CategoriasInterface $categoriasRepository)
    {
        $this->categoriasRepository = $categoriasRepository;
    }

    public function listarCategorias()
    {
        return $this->categoriasRepository->getAll();
    }

    public function obtenerCategoriaPorId(int $id)
    {
        return $this->categoriasRepository->getById($id);
    }

    public function crearCategoria(array $data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombre']);
        }

        return $this->categoriasRepository->create($data);
    }

    public function actualizarCategoria(int $id, array $data)
    {
        if (isset($data['nombre']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombre']);
        }

        return $this->categoriasRepository->update($id, $data);
    }

    public function eliminarCategoria(int $id)
    {
        return $this->categoriasRepository->delete($id);
    }

    public function buscarPorNombre(string $nombre)
    {
        return $this->categoriasRepository->findByNombre($nombre);
    }

    public function obtenerCategoriasConProductos()
    {
        return $this->categoriasRepository->getCategoriasExistentes();
    }
}