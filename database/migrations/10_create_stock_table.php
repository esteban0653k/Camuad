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
        Schema::create('stock', function (Blueprint $table) {
           
            $table->id('id_compra');

            $table->date("fecha_compra");
            $table->integer("cantidad");
            $table->integer("cantidad_min_stock");
            $table->enum("estado", ["activo", "pendiente", "inactivo"]);
            $table->boolean('notificado')->default(false);

            $table->string('producto', 100); 
            $table->foreign('producto')->references("sku")->on("producto")->onDelete("cascade");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("stock");
      
    }
};

