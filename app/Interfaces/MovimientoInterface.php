<?php

namespace App\Interfaces;

interface MovimientoInterface extends BaseInterface {
    public function getMovimientosConRelaciones(array $filtros = []);
    public function getMovimientoConRelaciones(string|int $id);
}