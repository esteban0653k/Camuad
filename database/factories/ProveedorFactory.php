<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proveedor;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition(): array
    {
        return [
            
            'nit_proveedor' => fake()->unique()->numerify('#########'),
            
            'nombre_proveedor' => fake()->company(),
            
            'telefono' => fake()->phoneNumber(),
            
            'correo_proveedor' => fake()->unique()->companyEmail(),
            
            'direccion' => fake()->address(),
        ];
    }
}