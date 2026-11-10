<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->string('documento_cliente');
            $table->dateTime('fecha_venta');
            $table->string('metodo_pago', 50)->nullable();
            $table->decimal('monto_recibido', 10, 2)->nullable();
            $table->decimal('cambio', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('documento_cliente')->references('numero_documento')->on('cliente')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};