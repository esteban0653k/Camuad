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
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('numero_documento', 50)->primary();
            $table->string('tipo_documento', 20);
            $table->string('nombre', 100);
            $table->string('correo', 150)->nullable();
            $table->string('telefono', 20)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::dropIfExists('cliente');
    }
};
