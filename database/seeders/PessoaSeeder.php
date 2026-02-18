<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Factories\PessoaFactory;
use Illuminate\Support\Facades\Log;
use App\Models\Pessoa;
use App\Models\Usuario;;

class PessoaSeeder extends Seeder
{
    public function run(): void
    {
        if (Usuario::count() === 0) {
            Log::warning('Nenhum usuário encontrado. Execute UsuarioSeeder antes.');
            return;
        }

        Pessoa::factory()->count(10)->create();
    }
}
