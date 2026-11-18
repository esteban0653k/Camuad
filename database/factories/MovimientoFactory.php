<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\TipoMovimiento;

class MovimientoFactory extends Factory
{
    protected $model = Movimiento::class;

    public function definition(): array
    {
        return [
            'fecha_movimiento' => fake()->dateTimeBetween('-1 month', 'now'),
            'cantidad' => fake()->numberBetween(1, 20),
            'estado' => 'Activo',
            'id_tipo_movimiento' => TipoMovimiento::inRandomOrder()->first()->id_tipo_movimiento ?? 1,
            'sku_producto' => Producto::inRandomOrder()->first()->sku ?? null,
            'id_venta' => Venta::inRandomOrder()->first()->id_venta ?? null,
            'id_compra' => null, 
        ];
    }
}