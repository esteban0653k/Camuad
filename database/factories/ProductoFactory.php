<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;
use App\Models\Categorias;
use App\Models\Marca;
use App\Models\Proveedor;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            
            'sku' => 'PROD-' . fake()->unique()->numberBetween(1000, 9999),
            'nombre_producto' => fake()->words(3, true), 
            'precio' => fake()->randomFloat(2, 10, 1000), 
            'precio_compra' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(1, 50),
            'estado' => 'Activo',
            'descripcion' => fake()->sentence(),
            'unidad_medida' => 'Unidad',
            'nit_proveedor' => Proveedor::inRandomOrder()->first()->nit_proveedor ?? null,
            'id_categoria' => Categorias::inRandomOrder()->first()->id ?? 1,
            'id_marca' => Marca::inRandomOrder()->first()->id_marca ?? 1,
        ];
    }
}