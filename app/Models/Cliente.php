<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliente';
    protected $primaryKey = 'numero_documento';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_documento',
        'tipo_documento',
        'nombre',
        'correo',
        'telefono',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'documento_cliente', 'numero_documento');
    }
}