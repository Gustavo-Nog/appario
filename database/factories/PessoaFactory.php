<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pessoa;
use App\Models\Usuario;
use Illuminate\Support\Str;



class PessoaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->firstName(),
            'sobrenome' => $this->faker->lastName(),
            'endereco' => $this->faker->address(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'tipo' => $this->faker->randomElement(['APICULTOR', 'RESPONSAVEL']),
            'usuario_id' => Usuario::inRandomOrder()->first()->id_usuarios,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
