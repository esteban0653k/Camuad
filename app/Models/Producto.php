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
        'stock',
        'descripcion',
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
}