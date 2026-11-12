<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model {

    use SoftDeletes;

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