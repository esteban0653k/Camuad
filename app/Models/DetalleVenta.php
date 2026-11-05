<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use SoftDeletes;

    protected $table = 'detalle_venta';
    protected $primaryKey = 'id_detalle_venta';

    protected $fillable = [
        'id_factura',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * Relación con la Factura
     */
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura');
    }
}