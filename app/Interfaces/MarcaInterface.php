<?php

namespace App\Interfaces;

interface MarcaInterface extends BaseInterface {
    
    public function findByNombre(string $nombre);
    public function existeProducto(string $nombre);
    public function getProductosExistentes();
    
}