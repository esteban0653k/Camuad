<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetalleCompra;
use App\Models\CompraProveedor;
use App\Models\Producto;

class DetalleCompraFactory extends Factory
{
    protected $model = DetalleCompra::class;

    public function definition(): array
    {
        
        $producto = Producto::inRandomOrder()->first();
        $cantidad = fake()->numberBetween(5, 50); 
        $costoUnitario = $producto ? $producto->precio_compra : 50;

        return [

            'id_compra' => CompraProveedor::inRandomOrder()->first()->id_compra ?? 1,
            'sku_producto' => $producto ? $producto->sku : null,
            'cantidad_solicitada' => $cantidad,
            'costo_unitario' => $costoUnitario,
            'subtotal' => $cantidad * $costoUnitario,
        ];
    }
}