<?php

namespace App\Repositories;

use App\Interfaces\RolInterface;
use App\Models\Rol;

class RolRepository implements RolInterface
{
    public function getAll()
    {
        return Rol::all();
    }

    public function getById(int $id)
    {
        return Rol::findOrFail($id);
    }

    public function create(array $data)
    {
        return Rol::create($data);
    }

    public function update(int $id, array $data)
    {
        $rol = Rol::findOrFail($id);
        $rol->update($data);
        return $rol;
    }

    public function delete(int $id)
    {
        return Rol::destroy($id);
    }
}