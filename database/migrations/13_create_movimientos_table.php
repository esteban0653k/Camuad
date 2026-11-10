<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->dateTime('fecha_movimiento');
            $table->unsignedInteger('cantidad');
            $table->string('estado', 50)->default('activo');

            $table->unsignedBigInteger('id_tipo_movimiento');
            $table->string('sku_producto', 100);
            $table->unsignedBigInteger('id_compra')->nullable();
            $table->unsignedBigInteger('id_venta')->nullable();

            $table->foreign('id_tipo_movimiento')
                  ->references('id_tipo_movimiento')
                  ->on('tipo_movimiento')
                  ->restrictOnDelete();

            $table->foreign('sku_producto')
                  ->references('sku')
                  ->on('producto')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreign('id_compra')
                  ->references('id_compra')
                  ->on('compra_proveedor')
                  ->restrictOnDelete();

            $table->foreign('id_venta')
                  ->references('id_venta')
                  ->on('venta')
                  ->restrictOnDelete();
        });

        // Un movimiento viene de una compra o de una venta, no de ambas
        // (los ajustes manuales pueden no tener ninguna)
        DB::statement(
            'ALTER TABLE movimientos ADD CONSTRAINT movimientos_origen_check
             CHECK (id_compra IS NULL OR id_venta IS NULL)'
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};