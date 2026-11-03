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
            $table->integer("cantidad")->nullable();
            $table->integer("cantidad_min_stock")->nullable();
            $table->boolean("activo");

            $table->unsignedBigInteger("producto"); 
            $table->foreign("producto")->references("id")->on("productos")->onDelete("cascade");

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

