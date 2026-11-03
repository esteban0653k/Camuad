<?php

    namespace App\Interfaces;

    interface CLienteInterface extends BaseInterface
    {
        public function findByNombre(string $nombre);
    }