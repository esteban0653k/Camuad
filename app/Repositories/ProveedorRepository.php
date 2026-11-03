<?php

namespace App\Repositories;
use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;
use App\Interfaces\ProveedorInterface;

class ProveedorRepository extends BaseRepository implements ProveedorInterface
{
    public function __construct(Proveedor $proveedor)
    {
        parent::__construct($proveedor);
    }

    public function findByName(string $nombre)
    {
        return $this->model->where("nombre_proveedor", "LIKE", "%". $nombre. "%")->get();
        
    }
    
    public function findByCorreo(string $nit)
    {
        return $this->model->where("correo_proveedor", "LIKE", "%". $correo. "%")->get();
    }
} 
