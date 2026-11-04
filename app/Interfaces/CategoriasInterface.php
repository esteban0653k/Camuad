<?php

namespace App\Interfaces;

use App\Models\Categorias;

interface CategoriasInterface extends BaseInterface
{
    public function findByNombre(string $nombre);
    public function existeCategoria(string $nombre);
    public function getCategoriasExistentes();
}