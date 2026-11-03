<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "proveedor";
    protected $primaryKey = 'nit_proveedor'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nit_proveedor',
        'nombre_proveedor',
        'telefono',
        'correo_proveedor',
        'direccion'
    ];

    public function productos(){
         return $this->hasMany(Producto::class, 'nit_proveedor'); 
    }

    public function solicitudStock(){
         return $this->hasMany(SolicitudStock::class, 'nit_proveedor'); 
    }
}