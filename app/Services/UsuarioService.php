<?php

namespace App\Services;

use App\Interfaces\UsuarioInterface;
use Illuminate\Validation\ValidationException;

class UsuarioService
{
    
    public function __construct(
        protected UsuarioInterface $repository
    ) {}
    public function obtener(int $id)
{
    return $this->repository->getById($id);
    }

    public function listar()
    {
        return $this->repository->getAll();
    }

    public function crear(array $data)
    {
        
        return $this->repository->create($data);
    }

    public function actualizar(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function eliminar(int $id)
    {
        return $this->repository->delete($id);
    }
}