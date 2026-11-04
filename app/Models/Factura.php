<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'factura';
    
    protected $fillable = [
        'numero_documento_cliente',
        'fecha_factura',
        'subtotal',
        'iva',
        'descuento',
        'total'
    ];

    public function cliente() 
    {
        return $this->belongsTo(Cliente::class, 'numero_documento_cliente', 'numero_documento');
    }

    public function detalles() 
    {
        return $this->hasMany(DetalleVenta::class, 'id_factura', 'id_factura');
    }
}
