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
            CREATE VIEW v_ventas_vs_egresos AS
            WITH ventas_mes AS (
                SELECT date_trunc('month', fecha_venta) AS mes,
                       SUM(subtotal) AS total_ventas
                FROM venta
                WHERE deleted_at IS NULL
                GROUP BY date_trunc('month', fecha_venta)
            ),
            compras_mes AS (
                SELECT date_trunc('month', created_at) AS mes,
                       SUM(total_compra) AS total_compras
                FROM compra_proveedor
                WHERE deleted_at IS NULL
                  AND estado <> 'cancelada'
                GROUP BY date_trunc('month', created_at)
            )
            SELECT COALESCE(v.mes, c.mes)                AS mes,
                   COALESCE(v.total_ventas, 0)           AS total_ventas,
                   COALESCE(c.total_compras, 0)          AS total_compras,
                   COALESCE(v.total_ventas, 0) - COALESCE(c.total_compras, 0)      AS diferencia
            FROM ventas_mes v
            FULL OUTER JOIN compras_mes c ON c.mes = v.mes
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_ventas_vs_egresos;");
    }
};
