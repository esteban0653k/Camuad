<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "solicitud_stock";
    protected $primaryKey = 'id_solicitud_reposicion';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
    
        'fecha_solicitud',
        'prioridad',
        'costo_unitario',
        'total_comprar',
        'cantidad_comprar',
        'stock',
        'nit_proveedor',
        'estado'

    ];

    public function stockItem(){
         return $this->belongsTo(Stock::class, 'stock', 'id_compra'); 
    }

   
}
