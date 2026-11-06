<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estadisticas extends Model
{
    use SoftDeletes;

    protected $table = 'estadisticas';
    protected $primaryKey = 'id_estadisticas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tipo_estadistica',
        'fecha_generacion',
        'id_reporte',
        'stock'
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'id_reporte', 'id_reporte');
    }

    
    public function stockItem()
    {
        return $this->belongsTo(Stock::class, 'stock', 'id_compra');
    }
}
