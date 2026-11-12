<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW v_valoracion_bodega AS
            SELECT 
                p.sku,
                p.nombre_producto,
                p.stock,
                p.precio_compra,
                (p.stock * p.precio_compra) AS valor_total_item,
                p.estado,
                m.nombre_marca AS marca,
                c.nombre AS categoria
            FROM producto p
            LEFT JOIN marca m ON p.id_marca = m.id_marca
            LEFT JOIN categorias c ON p.id_categoria = c.id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_valoracion_bodega;");
    }
};