<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleCompra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle_compra';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_compra',
        'sku_producto',
        'cantidad_solicitada',
        'costo_unitario',
        'subtotal',
    ];

    protected $casts = [
        'costo_unitario' => 'decimal:2',
        'subtotal'       => 'decimal:2',
    ];

    public function compra()
    {
        return $this->belongsTo(CompraProveedor::class, 'id_compra', 'id_compra');
    }

    public function producto()
{
    return $this->belongsTo(Producto::class, 'sku_producto', 'sku');
}
}
