<?php

namespace App\Interfaces;

interface ProductoInterface
{
    public function buscarPorNombre(string $nombre);
    public function obtenerProductosConRelaciones();
}