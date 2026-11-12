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
            CREATE OR REPLACE VIEW v_ventas AS
            SELECT 
                v.id_venta,
                v.fecha_venta,
                v.total,
                v.documento_cliente,
                c.nombre AS nombre_cliente,
                v.metodo_pago
            FROM venta v
            INNER JOIN cliente c ON v.documento_cliente = c.numero_documento;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_ventas;");
    }
};
