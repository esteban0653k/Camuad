<?php

    namespace App\Interfaces;

    interface ClienteInterface extends BaseInterface 
    {
        public function findByNombre(string $nombre);
    }