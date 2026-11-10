<?php

namespace App\Repositories;

use App\Models\Movimiento;
use App\Interfaces\MovimientoInterface;

class MovimientoRepository extends BaseRepository implements MovimientoInterface {

    public function __construct(Movimiento $model) {
        parent::__construct($model);
    }

    public function getMovimientosConRelaciones(array $filtros = []) {
        return $this->model
            ->with('tipo', 'producto')
            ->when($filtros['sku_producto'] ?? null, fn ($q, $v) => $q->where('sku_producto', $v))
            ->when($filtros['id_tipo_movimiento'] ?? null, fn ($q, $v) => $q->where('id_tipo_movimiento', $v))
            ->when($filtros['id_venta'] ?? null, fn ($q, $v) => $q->where('id_venta', $v))
            ->when($filtros['id_compra'] ?? null, fn ($q, $v) => $q->where('id_compra', $v))
            ->when($filtros['desde'] ?? null, fn ($q, $v) => $q->whereDate('fecha_movimiento', '>=', $v))
            ->when($filtros['hasta'] ?? null, fn ($q, $v) => $q->whereDate('fecha_movimiento', '<=', $v))
            ->orderByDesc('fecha_movimiento')
            ->get();
    }

    public function getMovimientoConRelaciones(string|int $id) {
        return $this->model->with('tipo', 'producto', 'venta')->find($id);
    }
}