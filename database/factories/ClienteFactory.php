<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
          
            'numero_documento' => fake()->unique()->numerify('##########'),
            'tipo_documento' => fake()->randomElement(['CC', 'CE', 'Pasaporte']),
            'nombre' => fake()->name(),
            'correo' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
        ];
    }
}