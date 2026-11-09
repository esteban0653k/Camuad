<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitud_stock', function (Blueprint $table) {

            $table->id('id_solicitud_reposicion');

            $table->date('fecha_solicitud');
            $table->enum('Prioridad', ['alta', 'media', 'baja']);            
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('total_compra', 12, 2);
            $table->integer('cantidad_comprar');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');

            $table->string('nit_proveedor', 50);
            $table->foreign('nit_proveedor')->references('nit_proveedor')->on('proveedor')->onDelete('cascade');

            $table->unsignedBigInteger('stock_id'); // O puedes mantener el nombre 'stock' si prefieres
            $table->foreign('stock_id')->references('id_compra')->on('stock')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_stock');
    }
};