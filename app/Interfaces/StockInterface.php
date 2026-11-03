<?php

namespace App\Interfaces;

interface ProveedorInterface extends BaseInterface
{
    public function findByEstado(bool $activo);
    public function findFechaCompra(string $fecha);
    public function findLowStock();
}   