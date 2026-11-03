<?php

namespace App\Interfaces;

interface ProveedorInterface extends BaseInterface
{
    public function findByName(string $nombre);
    public function findByCorreo(string $correo);
}