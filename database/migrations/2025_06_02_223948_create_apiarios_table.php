<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apiarios', function (Blueprint $table) {
            $table->id('id_apiario');
            $table->float('area');
            $table->string('coordenadas', 70);
            $table->timestamp('data_criacao')->useCurrent(); // Equivalente a `created_at`
            $table->unsignedBigInteger('pessoa_id'); // Chave estrangeira para pessoas
            $table->foreign('pessoa_id')->references('id_pessoa')->on('pessoas')->onDelete('cascade'); // Chave estrangeira para pessoas
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('apiarios');
    }
};
