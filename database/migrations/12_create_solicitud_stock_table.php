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

            $table->date("fecha_solicitud");
            $table->enum("prioridad", ['baja', 'media', 'alta']);
            $table->decimal("costo_unitario", 10, 2)->nullable();
            $table->integer("total_compra", 12, 2);
            $table->integer("cantidad_comprar");


            $table->unsignedBigInteger("stock"); 
            $table->foreign("stock")->references("id_compra")->on("stock")->onDelete("cascade");

            $table->unsignedBigInteger("nit_proveedor"); 
            $table->foreign("nit_proveedor")->references("id")->on("proveedores")->onDelete("cascade");

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

