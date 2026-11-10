<?php

namespace App\Services;

use App\Interfaces\CompraProveedorInterface;
use App\Interfaces\DetalleCompraInterface;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CompraProveedorService
{
    protected CompraProveedorInterface $compraRepository;
    protected DetalleCompraInterface $detalleRepository;

    public const ESTADOS = ['pendiente', 'enviada', 'recibida', 'cancelada'];

    public function __construct(
        CompraProveedorInterface $compraRepository,
        DetalleCompraInterface $detalleRepository
    ) {
        $this->compraRepository = $compraRepository;
        $this->detalleRepository = $detalleRepository;
    }

    public function getAll()
    {
        return $this->compraRepository->getAll();
    }

    public function getById(string $id)
    {
        return $this->compraRepository->getById($id);
    }

    /**
     * Crea la compra y, si vienen detalles, los crea y calcula el total.
     * $data['detalles'] = [['sku_producto' => '...', 'cantidad_solicitada' => 5, 'costo_unitario' => 1000], ...]
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $detalles = $data['detalles'] ?? [];
            unset($data['detalles']);

            $data['estado'] = $data['estado'] ?? 'pendiente';
            $data['total_compra'] = 0;

            $compra = $this->compraRepository->create($data);

            foreach ($detalles as $detalle) {
                $detalle['id_compra'] = $compra->id_compra;
                $detalle['subtotal'] = $detalle['cantidad_solicitada'] * $detalle['costo_unitario'];

                $this->detalleRepository->create($detalle);
            }

            if (!empty($detalles)) {
                $this->compraRepository->actualizarTotal($compra->id_compra);
            }

            return $this->compraRepository->findWithDetalles($compra->id_compra);
        });
    }

    public function update(string $id, array $data)
    {
        // El total siempre se calcula desde los detalles, no se edita a mano
        unset($data['total_compra']);

        if (isset($data['estado'])) {
            $this->validarEstado($data['estado']);
        }

        return $this->compraRepository->update($id, $data);
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $this->detalleRepository->deleteByCompra((int) $id);

            return $this->compraRepository->delete($id);
        });
    }

    public function obtenerConDetalles(int $idCompra)
    {
        return $this->compraRepository->findWithDetalles($idCompra);
    }

    public function listarPendientes()
    {
        return $this->compraRepository->findPendientes();
    }

    public function listarPorEstado(string $estado)
    {
        $this->validarEstado($estado);

        return $this->compraRepository->findByEstado($estado);
    }

    public function listarPorProveedor(string $nitProveedor)
    {
        return $this->compraRepository->findByProveedor($nitProveedor);
    }

}