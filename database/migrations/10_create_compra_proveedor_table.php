<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_proveedor', function (Blueprint $table) {
            $table->id('id_compra');

            $table->decimal('total_compra', 10, 2)->default(0);
            $table->string('estado', 50)->default('pendiente');
            $table->string('nit_proveedor', 20);

            $table->foreign('nit_proveedor')->references('nit_proveedor')->on('proveedor')->restrictOnDelete()->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_proveedor');
    }
};
