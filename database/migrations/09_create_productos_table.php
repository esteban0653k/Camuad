<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            
            $table->string('sku', 100)->primary();
            
            $table->string('nombre_producto');
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->text('descripcion')->nullable();
            
            
            $table->foreignId('id_categoria')->constrained('categorias', 'id')->onDelete('cascade');
            $table->foreignId('id_marca')->constrained('marcas', 'id_marca')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};