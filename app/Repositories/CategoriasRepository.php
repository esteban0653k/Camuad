<?php

namespace App\Repositories;

use App\Models\Categorias;
use App\Interfaces\CategoriasInterface;

class CategoriasRepository extends BaseRepository implements CategoriasInterface
{
    public function __construct(Categorias $model)
    {
        parent::__construct($model);
    }

    public function findByNombre(string $nombre)
    {
        return $this->model->where('nombre', 'LIKE', "%{$nombre}%")->get();
    }

    public function existeCategoria(string $nombre)
    {
        return $this->model->where('nombre', $nombre)->exists();
    }

    public function getCategoriasExistentes()
    {
        return $this->model->has('products')->get();
    }
}