<?php

namespace App\Services;

use App\Interfaces\DetalleCompraInterface;
use App\Interfaces\CompraProveedorInterface;
use Illuminate\Support\Facades\DB;

class DetalleCompraService
{
    protected DetalleCompraInterface $detalleRepository;
    protected CompraProveedorInterface $compraRepository;

    public function __construct(
        DetalleCompraInterface $detalleRepository,
        CompraProveedorInterface $compraRepository
    ) {
        $this->detalleRepository = $detalleRepository;
        $this->compraRepository = $compraRepository;
    }

    public function getAll()
    {
        return $this->detalleRepository->getAll();
    }

    public function getById(string $id)
    {
        return $this->detalleRepository->getById($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Si el producto ya está en la compra, se suma la cantidad en vez de duplicar la fila
            $existente = $this->detalleRepository->findByCompraAndSku(
                $data['id_compra'],
                $data['sku_producto']
            );

            if ($existente) {
                $cantidad = $existente->cantidad_solicitada + $data['cantidad_solicitada'];
                $costo = $data['costo_unitario'] ?? $existente->costo_unitario;

                $detalle = $this->detalleRepository->update($existente->id_detalle_compra, [
                    'cantidad_solicitada' => $cantidad,
                    'costo_unitario' => $costo,
                    'subtotal' => $cantidad * $costo,
                ]);
            } else {
                $data['subtotal'] = $data['cantidad_solicitada'] * $data['costo_unitario'];
                $detalle = $this->detalleRepository->create($data);
            }

            $this->compraRepository->actualizarTotal($data['id_compra']);

            return $detalle;
        });
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $actual = $this->detalleRepository->getById($id);

            if ($actual && (isset($data['cantidad_solicitada']) || isset($data['costo_unitario']))) {
                $cantidad = $data['cantidad_solicitada'] ?? $actual->cantidad_solicitada;
                $costo = $data['costo_unitario'] ?? $actual->costo_unitario;

                $data['subtotal'] = $cantidad * $costo;
            }

            $detalle = $this->detalleRepository->update($id, $data);

            if ($actual) {
                $this->compraRepository->actualizarTotal($actual->id_compra);
            }

            return $detalle;
        });
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $actual = $this->detalleRepository->getById($id);

            $resultado = $this->detalleRepository->delete($id);

            if ($actual) {
                $this->compraRepository->actualizarTotal($actual->id_compra);
            }

            return $resultado;
        });
    }

    public function listarPorCompra(int $idCompra)
    {
        return $this->detalleRepository->findWithProducto($idCompra);
    }

    public function listarPorSku(string $sku)
    {
        return $this->detalleRepository->findBySku($sku);
    }
}