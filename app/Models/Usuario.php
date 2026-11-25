<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    public function getRolNombre(): ?string
    {
        return $this->rol?->nombre;
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'rol' => $this->getRolNombre(),
        ];
    }

    public function getPermission(): array
    {
        return $this->rol?->permissions() ?? [];
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getPermission(), true);
    }

    public function hasRol(string $role): bool
    {
        return $this->getRolNombre() === $role;
    }
}