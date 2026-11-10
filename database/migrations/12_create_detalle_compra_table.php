<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_compra', function (Blueprint $table) {
            $table->id('id_detalle_compra');

            $table->unsignedBigInteger('id_compra');
            $table->string('sku_producto', 50);

            $table->unsignedInteger('cantidad_solicitada');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2)->default(0);

            $table->foreign('id_compra')->references('id_compra')->on('compra_proveedor')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('sku_producto')->references('sku')->on('producto')->restrictOnDelete()->cascadeOnUpdate();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_compra');
    }
};

