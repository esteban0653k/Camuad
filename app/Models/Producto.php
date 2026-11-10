<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    
    protected $primaryKey = 'sku';
    public $incrementing = false;  
    protected $keyType = 'string'; 

    protected $fillable = [
        'sku',
        'nombre_producto',
        'precio',
        'precio_compra',
        'stock',
        'estado',
        'descripcion',
        'unidad_medida',
        'nit_proveedor', 
        'id_categoria',
        'id_marca',
    ];

    public function getRouteKeyName(): string
    {
        return 'sku';
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categorias::class, 'id_categoria', 'id');
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'nit_proveedor', 'nit_proveedor');
    }
}