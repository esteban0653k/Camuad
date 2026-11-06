<?php

namespace App\Services;

use App\Interfaces\ProveedorInterface;

class ProveedorService
{
    protected ProveedorInterface $proveedorRepository;

    public function __construct(ProveedorInterface $proveedorRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
    }


    public function getAll(){
        return $this->proveedorRepository->getAll();  
    }


    public function getById(string $nit){
        return $this->proveedorRepository->getById($nit);  
    }

    public function create(array $data)
    {
        return $this->proveedorRepository->create($data); 
    }


    public function update(string $nit, array $data)
    {
        return $this->proveedorRepository->update($nit, $data);
    }

    public function delete(string $nit)
    {
        return $this->proveedorRepository->delete($nit);
    }

    public function findByName(string $nombre)
    {
        return $this->proveedorRepository->findByName($nombre);
        
    }
    
    public function findByCorreo(string $correo)
    {
        return $this->proveedorRepository->findByCorreo($correo);
    }


}