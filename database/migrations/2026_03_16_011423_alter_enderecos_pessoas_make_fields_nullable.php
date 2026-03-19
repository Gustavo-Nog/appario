<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enderecos_pessoas', function (Blueprint $table) {
            $table->string('logradouro', 80)->nullable()->change();
            $table->string('numero', 10)->nullable()->change();
            $table->string('bairro', 50)->nullable()->change();
            $table->string('cep', 10)->nullable()->change();
            $table->string('cidade', 50)->nullable()->change();
            $table->char('estado', 2)->nullable()->change();
            $table->string('complemento', 75)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('enderecos_pessoas', function (Blueprint $table) {
            $table->string('logradouro', 80)->nullable(false)->change();
            $table->string('numero', 10)->nullable(false)->change();
            $table->string('bairro', 50)->nullable(false)->change();
            $table->string('cep', 10)->nullable(false)->change();
            $table->string('cidade', 50)->nullable(false)->change();
            $table->char('estado', 2)->nullable(false)->change();
            $table->string('complemento', 75)->nullable()->change();
        });
    }
};