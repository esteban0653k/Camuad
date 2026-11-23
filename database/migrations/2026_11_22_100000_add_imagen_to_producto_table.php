<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('producto', fn (Blueprint $t) => $t->string('imagen')->nullable());
    }

    public function down(): void
    {
        Schema::table('producto', fn (Blueprint $t) => $t->dropColumn('imagen'));
    }
};