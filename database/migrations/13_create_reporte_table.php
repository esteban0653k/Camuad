<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->string('tipo_reporte', 100)->nullable();
            $table->float('total_ingresos', 10, 2)->nullable();
            $table->float('total_egresos', 10, 2)->nullable();
            $table->float('ganancias', 10, 2)->nullable();
            $table->string('producto_vendido', 100)->nullable();
            $table->integer('cantidad_vendida')->nullable();
            
            $table->unsignedBigInteger('factura')->nullable();
            $table->unsignedBigInteger('solicitud_stock')->nullable();

            $table->timestamps();
            $table->softDeletes();

            
            $table->foreign('factura')->references('id_factura')->on('factura')->onDelete('set null');
            $table->foreign('solicitud_stock')->references('id_solicitud_reposicion')->on('solicitud_stock')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte');
    }
};