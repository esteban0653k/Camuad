<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'factura';
    protected $primaryKey = 'id_factura';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'numero_documento_cliente',
        'fecha_factura',
        'metodo_pago',  
        'monto_recibido', 
        'cambio',
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
