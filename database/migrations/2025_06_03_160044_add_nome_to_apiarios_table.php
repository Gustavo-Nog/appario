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
        Schema::table('apiarios', function (Blueprint $table) {
            $table->string('nome', 100)->after('id_apiario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apiarios', function (Blueprint $table) {
            if (Schema::hasColumn('apiarios', 'nome')) {
                $table->dropColumn('nome');
            }
        });
    }

};
