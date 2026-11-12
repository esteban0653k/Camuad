
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
            CREATE OR REPLACE VIEW v_detalle_compras AS
            SELECT 
                dc.id_compra, 
                pro.nombre_producto, 
                dc.cantidad_solicitada,
                pro.sku
            FROM detalle_compra dc
            INNER JOIN compra_proveedor c 
                ON dc.id_compra = c.id_compra
            INNER JOIN producto pro 
                ON dc.sku_producto = pro.sku;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_detalle_compras;");
    }
};