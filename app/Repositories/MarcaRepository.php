<?php
namespace App\Repositories;

use App\Models\Marca;
use App\Interfaces\MarcaInterface;

class MarcaRepository extends BaseRepository implements MarcaInterface {
    public function __construct(Marca $model) {
        parent::__construct($model);
    }

    public function findByNombre(string $nombre) {
        return $this->model->where('nombre_marca', 'LIKE', "%{$nombre}%")->get();
    }

    public function existeProducto (string $nombre){
        return $this->model->where('nombre_marca', $nombre)->exists();
    }

        public function getProductosExistentes(){
        return $this->model->has('productos')->get();
    }
}