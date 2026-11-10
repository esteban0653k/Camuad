<?php

namespace App\Interfaces;

interface CompraProveedorInterface extends BaseInterface
{
    public function findByEstado(string $estado);
    public function findByProveedor(string $nitProveedor);
    public function findByFechaCompra(string $fecha);
    public function findByRangoFechas(string $fechaInicio, string $fechaFin);
    public function findWithDetalles(int $idCompra);
    public function findPendientes();
    public function actualizarTotal(int $idCompra);
}
