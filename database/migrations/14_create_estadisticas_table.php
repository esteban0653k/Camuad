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
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id('id_estadisticas');
            $table->string('tipo_estadistica', 100)->nullable();
            $table->dateTime('fecha_generacion')->useCurrent();
            
            $table->unsignedBigInteger('id_reporte')->nullable();
            $table->unsignedBigInteger('stock')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_reporte')->references('id_reporte')->on('reporte')->onDelete('set null');
            $table->foreign('stock')->references('id_compra')->on('stock')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadisticas');
    }
};
