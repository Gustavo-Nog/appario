<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('tipo_usuario')->nullable()->after('password');
        });

        Schema::table('pessoas', function (Blueprint $table) {
            $table->string('tipo_pessoa')->nullable()->after('cpf');
        });
    }

    public function down(): void
    {
        Schema::table('pessoas', fn($table) => $table->dropColumn('tipo_pessoa'));
        Schema::table('usuarios', fn($table) => $table->dropColumn('tipo_usuario'));
    }
};
