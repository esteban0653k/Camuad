<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre_producto');
            $table->string('sku')->unique();
            $table->decimal('precio', 10, 5);
            $table->integer('stock')->default(0);
            $table->text('descripcion')->nullable();
            
            
            $table->foreignId('id_categoria')->constrained('categorias', 'id')->onDelete('cascade');
            $table->foreignId('id_marca')->constrained('marca', 'id_marca')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
