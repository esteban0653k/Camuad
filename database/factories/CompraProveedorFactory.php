<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompraProveedor;
use App\Models\Proveedor;

class CompraProveedorFactory extends Factory
{
    protected $model = CompraProveedor::class;

    public function definition(): array
    {
        return [
            'total_compra' => fake()->randomFloat(2, 100, 5000),
            'estado' => fake()->randomElement(['Recibida', 'Pendiente', 'Cancelada']),
            'nit_proveedor' => Proveedor::inRandomOrder()->first()->nit_proveedor ?? null,
        ];
    }
}
