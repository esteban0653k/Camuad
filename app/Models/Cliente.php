<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;

class Cliente extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'cliente';
    protected $primaryKey = 'numero_documento';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_documento',
        'tipo_documento',
        'nombre',
        'correo',
        'telefono'
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'numero_documento', 'numero_documento');
    }
}
