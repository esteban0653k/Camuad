<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Producto;

class DetalleVentaFactory extends Factory
{
    protected $model = DetalleVenta::class;

    public function definition(): array
    {

        $producto = Producto::inRandomOrder()->first();
        $cantidad = fake()->numberBetween(1, 5);
        $precioUnitario = $producto ? $producto->precio : 100;
    
        return [
        
            'id_venta' => Venta::inRandomOrder()->first()->id_venta ?? 1,
            'sku_producto' => $producto ? $producto->sku : null,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'subtotal' => $cantidad * $precioUnitario,
            'estado_venta' => fake()->randomElement(['Completado', 'Pendiente', 'Devuelto']),
        ];
    }
}