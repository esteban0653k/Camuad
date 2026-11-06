<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporte extends Model
{
    use SoftDeletes;

    protected $table = 'reporte';
    protected $primaryKey = 'id_reporte';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tipo_reporte',
        'total_ingresos',
        'total_egresos',
        'ganancias',
        'producto_vendido',
        'cantidad_vendida',
        'factura',
        'solicitud_stock'
    ];

    // Relaciones opcionales si las necesitas en Eloquent
    public function facturaRelacion()
    {
        return $this->belongsTo(Factura::class, 'factura', 'id_factura');
    }
}