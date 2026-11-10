<?php

namespace App\Repositories;

use App\Models\TipoMovimiento;
use App\Interfaces\TipoMovimientoInterface;

class TipoMovimientoRepository extends BaseRepository implements TipoMovimientoInterface {

    public function __construct(TipoMovimiento $model) {
        parent::__construct($model);
    }
}