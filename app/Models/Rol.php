<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'role_id');
    }

    public function permissions(): array
    {
        if (!$this->nombre) {
            return [];
        }

        $permissions = config('rol.' . strtolower($this->nombre), []);

        return is_array($permissions) ? $permissions : [];
    }
}