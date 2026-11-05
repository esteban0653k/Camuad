<?php

namespace App\Interfaces;

interface SolicitudStockInterface extends BaseInterface
{
    public function findByProveedor(string $nit);
    public function findByPrioridad(string $prioridad);
    public function findFechaSolicitud(string $fecha);
}