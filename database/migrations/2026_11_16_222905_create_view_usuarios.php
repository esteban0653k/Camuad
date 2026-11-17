<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW v_usuarios AS
            SELECT 
                u.id AS id_usuario,
                u.nombre AS nombre_usuario,
                u.email,
                r.nombre AS nombre_rol
            FROM usuarios u
            INNER JOIN roles r ON u.role_id = r.id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_usuarios;");
    }
};