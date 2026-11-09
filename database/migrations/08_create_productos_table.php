<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('producto')) {
            Schema::create('producto', function (Blueprint $table) {
                $table->string('sku', 100)->primary();
                $table->string('nombre_producto', 255);
                $table->decimal('precio', 10, 2);
                $table->decimal('precio_compra', 10, 2);
                $table->integer('stock')->default(0);
                $table->text('descripcion')->nullable();
                $table->string('unidad_medida', 50)->nullable();
                
                $table->unsignedBigInteger('id_categoria');
                $table->unsignedBigInteger('id_marca');
                
                
                $table->string('nit_proveedor', 20);
                $table->foreign('nit_proveedor')->references('nit_proveedor')->on('proveedor')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};