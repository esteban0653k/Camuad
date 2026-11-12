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
            CREATE OR REPLACE VIEW historial_compras AS
            SELECT 
                c.id_compra, 
                prov.nit_proveedor, 
                prov.nombre_proveedor, 
                c.total_compra, 
                c.estado 
            FROM compra_proveedor c 
            INNER JOIN proveedor prov 
                ON c.nit_proveedor = prov.nit_proveedor;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS historial_compras;");
    }
};