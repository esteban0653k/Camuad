<?php

namespace App\Repositories;

use App\Models\CompraProveedor;
use App\Interfaces\CompraProveedorInterface;

class CompraProveedorRepository extends BaseRepository implements CompraProveedorInterface
{
    public function __construct(CompraProveedor $compraProveedor)
    {
        parent::__construct($compraProveedor);
    }

    public function findByEstado(string $estado)
    {
        return $this->model->where("estado", $estado)->get();
    }

    public function findByProveedor(string $nitProveedor)
    {
        return $this->model->where("nit_proveedor", $nitProveedor)->get();
    }

    public function findByFechaCompra(string $fecha)
    {
        return $this->model->whereDate("fecha_compra", $fecha)->get();
    }

    public function findByRangoFechas(string $fechaInicio, string $fechaFin)
    {
        return $this->model
            ->whereBetween("fecha_compra", [$fechaInicio, $fechaFin])
            ->get();
    }

    public function findWithDetalles(int $idCompra)
    {
        return $this->model
            ->with(["detalles", "proveedor"])
            ->findOrFail($idCompra);
    }

    public function findPendientes()
    {
        return $this->model->where("estado", "pendiente")->get();
    }

    public function actualizarTotal(int $idCompra)
    {
        $compra = $this->model->findOrFail($idCompra);

        $compra->total_compra = $compra->detalles()->sum("subtotal");
        $compra->save();

        return $compra;
    }
}