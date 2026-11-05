<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "stock";
    protected $primaryKey = 'id_compra';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
    
        'fecha_compra',
        'cantidad',
        'cantidad_min_stock',
        'estado',
        'notificado',
        'producto'
    ];

    public function productos(){
         return $this->belongsTo(Producto::class, 'producto', 'sku'); 
    }

    public function estadisticas(){
         return $this->hasMany(Estadistica::class, 'stock', 'id_compra'); 
    }

     public function solicitudStock(){
         return $this->hasMany(SolicitudStock::class, 'stock', 'id_compra'); 
    }
}
