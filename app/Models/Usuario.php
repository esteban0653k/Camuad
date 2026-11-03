<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class usuario extends Model
{
 use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role_id',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }
}