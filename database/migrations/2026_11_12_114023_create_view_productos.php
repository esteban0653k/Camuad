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
         DB::statement("
            CREATE OR REPLACE VIEW detalle_productos AS 
                SELECT p.nombre_producto as producto, 
                        c.nombre as categoria, 
                        m.nombre_marca as 
	                    marca, 
                        p.stock, 
                        p.precio, 
                        p.estado
	                    FROM producto p 
		        inner join categorias c on c.id = p.id_categoria
		        inner join marca m on m.id_marca = p.id_marca;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS detalle_productos;");
    }
};
