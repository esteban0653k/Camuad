<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use SoftDeletes;

    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'documento_cliente',
        'fecha_venta',
        'metodo_pago',
        'monto_recibido',
        'cambio',
        'subtotal',
        'iva',
        'descuento',
        'total',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'documento_cliente', 'numero_documento');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }
}