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
            $table->string('coordenadas')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('apiarios', function (Blueprint $table) {
            $table->string('coordenadas')->nullable(false)->change(); // se quiser reverter
        });
    }

};
