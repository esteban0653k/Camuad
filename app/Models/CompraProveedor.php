<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompraProveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compra_proveedor';
    protected $primaryKey = 'id_compra';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'total_compra',
        'estado',
        'nit_proveedor',
    ];

    protected $casts = [
        'total_compra' => 'decimal:2',
    ];

   
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'nit_proveedor', 'nit_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra', 'id_compra');
    }

    public function notificaciones()
    {
        return $this->hasMany(NotificacionProveedor::class, 'id_compra', 'id_compra');
    }
}
