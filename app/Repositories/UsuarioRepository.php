<?php

namespace App\Repositories;

use App\Interfaces\UsuarioInterface;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioRepository implements UsuarioInterface
{
    public function getAll()
    {
        return Usuario::with('rol')->get();
    }

    public function getById(int $id)
    {
        return Usuario::with('rol')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return Usuario::create($data);
    }

    public function update(int $id, array $data)
    {
        $usuario = Usuario::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $usuario->update($data);
        return $usuario;
    }

    public function delete(int $id)
    {
        return Usuario::destroy($id);
    }
}