<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW v_roles AS
            SELECT 
                r.id AS id_rol,
                r.nombre AS nombre_rol,
                COUNT(u.id) AS total_usuarios
            FROM roles r
            LEFT JOIN usuarios u ON r.id = u.role_id
            GROUP BY r.id, r.nombre;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_roles;");
    }
};