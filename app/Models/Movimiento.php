<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'fecha_movimiento', 
        'cantidad', 'estado',
        'id_tipo_movimiento', 
        'sku_producto', 
        'id_compra'
        ,'id_venta',
    ];

    public function tipo()     { return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento', 'id_tipo_movimiento'); }
    public function producto() { return $this->belongsTo(Producto::class, 'sku_producto', 'sku'); }
    public function venta()    { return $this->belongsTo(Venta::class, 'id_venta', 'id_venta'); }
}