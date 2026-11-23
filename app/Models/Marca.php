<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model {

    use SoftDeletes;
    use HasFactory;

    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    public $timestamps = true;
    
    protected $fillable = [
        'nombre_marca'
    ];

    public function productos() {
        return $this->hasMany(Producto::class, 'id_marca', 'id_marca');
    }
}