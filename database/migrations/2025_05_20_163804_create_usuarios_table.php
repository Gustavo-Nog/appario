<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void // 'up' método usado para adicionar novas tabelas, colunas ou índices ao seu banco de dados,
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuarios');
            $table->string('email')->unique();
            $table->string('senha', 60);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();  // Adicionei token de "lembrar-me"
            $table->enum('tipo', ['ADMIN', 'PESSOA']);
            $table->timestamps();
        });
    }

    public function down(): void // método deve reverter as operações realizadas pelo 'up' método.
    {
        Schema::dropIfExists('usuarios');
    }
};
