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
        Schema::create('colmeias', function (Blueprint $table) {
            $table->id('id_colmeia');
            $table->string('especie', 50);
            $table->string('tamanho', 35);
            $table->date('data_aquisicao');
            $table->unsignedBigInteger('apiario_id');
            $table->foreign('apiario_id')
                ->references('id_apiario')
                ->on('apiarios')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colmeias');
    }
};
