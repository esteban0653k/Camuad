<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitud_stock';
    protected $primaryKey = 'id_solicitud_reposicion';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'fecha_solicitud',
        'prioridad',
        'costo_unitario',
        'total_compra',
        'cantidad_comprar',
        'nit_proveedor',
        'stock'
    ];

    /**
     * Relación con el Proveedor (Pertenece a)
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'nit_proveedor', 'nit_proveedor');
    }

    /**
     * Relación con el Stock (Pertenece a)
     */
    public function stockRelacion()
    {
        return $this->belongsTo(Stock::class, 'stock', 'id_compra');
    }
}
