<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Interfaces\ClienteInterface;

class ClienteRepository extends BaseRepository implements ClienteInterface 
{
    public function __construct(Cliente $model)
    {
        parent::__construct($model);
    }

    public function findByNombre(string $nombre)
    {
        return $this->model->where('nombre', 'LIKE', "%{$nombre}%")->get();
    }
}