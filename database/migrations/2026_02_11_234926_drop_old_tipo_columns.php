<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // drop postgres CHECK constraint if exists (safe)
        DB::statement("ALTER TABLE usuarios DROP CONSTRAINT IF EXISTS usuarios_tipo_check");
        DB::statement("ALTER TABLE pessoas DROP CONSTRAINT IF EXISTS pessoas_tipo_check");

        // drop old columns if exist
        if (Schema::hasColumn('pessoas', 'tipo')) {
            Schema::table('pessoas', function (Blueprint $table) {
                $table->dropColumn('tipo');
            });
        }

        if (Schema::hasColumn('usuarios', 'tipo')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('tipo');
            });
        }
    }

    public function down(): void
    {
        // restore as nullable string (or recreate enum if desired)
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('tipo')->nullable()->after('password');
        });
        Schema::table('pessoas', function (Blueprint $table) {
            $table->string('tipo')->nullable()->after('cpf');
        });
    }
};
