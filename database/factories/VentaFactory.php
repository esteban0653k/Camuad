<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venta;
use App\Models\Cliente;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
    
        $subtotal = fake()->randomFloat(2, 50, 2000);
        $iva = $subtotal * 0.19; 
        $descuento = fake()->randomFloat(2, 0, 50);
        $total = ($subtotal + $iva) - $descuento;
        $monto_recibido = $total + fake()->randomFloat(2, 0, 100); 

        return [
            
            'documento_cliente' => Cliente::inRandomOrder()->first()->numero_documento ?? null,
            'fecha_venta' => fake()->dateTimeBetween('-3 months', 'now'),
            'metodo_pago' => fake()->randomElement(['Efectivo', 'Tarjeta', 'Transferencia']),
            'monto_recibido' => $monto_recibido,
            'cambio' => $monto_recibido - $total,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'descuento' => $descuento,
            'total' => $total,
        ];
    }
}