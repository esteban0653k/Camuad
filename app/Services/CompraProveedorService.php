<?php

namespace App\Services;

use App\Interfaces\CompraProveedorInterface;
use App\Interfaces\DetalleCompraInterface;
use App\Models\CompraProveedor;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $detalles = $data['detalles'] ?? [];
            unset($data['detalles']);

            $data['estado'] = $data['estado'] ?? 'pendiente';
            $this->validarEstado($data['estado']);
            $data['total_compra'] = 0;

            $compra = $this->compraRepository->create($data);

            foreach ($detalles as $detalle) {
                $detalle['id_compra'] = $compra->id_compra;
                $detalle['subtotal'] = $detalle['cantidad_solicitada'] * $detalle['costo_unitario'];

                $this->detalleRepository->create($detalle);
            }

            if (!empty($detalles)) {
                $this->recalcularTotal($compra->id_compra);
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

    public function recalcularTotal(int|string $idCompra)
    {
        $total = DetalleCompra::where('id_compra', $idCompra)
            ->selectRaw('COALESCE(SUM(cantidad_solicitada * costo_unitario), 0) as total')
            ->value('total');

        CompraProveedor::where('id_compra', $idCompra)
            ->update(['total_compra' => $total]);

        return $total;
    }

    private function validarEstado(string $estado): void
    {
        if (!in_array($estado, self::ESTADOS, true)) {
            throw ValidationException::withMessages([
                'estado' => ['Estado inválido. Valores permitidos: ' . implode(', ', self::ESTADOS) . '.']
            ]);
        }
    }
}