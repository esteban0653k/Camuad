<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW v_productos_mas_vendidos AS
            SELECT 
                pro.sku, 
                pro.nombre_producto, 
                SUM(dv.cantidad) AS total_vendido
            FROM detalle_venta dv
            INNER JOIN producto pro 
                ON dv.sku_producto = pro.sku
            GROUP BY pro.sku, pro.nombre_producto
            ORDER BY total_vendido DESC;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_productos_mas_vendidos;");
    }
};