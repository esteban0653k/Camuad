<?php

namespace App\Interfaces;

interface FacturaRepositoryInterface extends BaseInterface {
    public function getFacturasConCliente();
}