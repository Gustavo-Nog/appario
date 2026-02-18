<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('enderecos_apiarios', function (Blueprint $table) {
            $table->id('id_endereco');
            $table->string('logradouro', 80);
            $table->string('numero', 10);
            $table->string('complemento', 75)->nullable();
            $table->string('bairro', 50);
            $table->string('cep', 10);
            $table->string('cidade', 50);
            $table->char('estado', 2); // UF (ex: SP, RJ)
            $table->unsignedBigInteger('apiario_id'); // Chave estrangeira para apiarios
            $table->foreign('apiario_id')->references('id_apiario')->on('apiarios')->onDelete('cascade'); // Chave estrangeira para apiarios
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos_apiarios');
    }
};
