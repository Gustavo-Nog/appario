<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'senha' => bcrypt('senha123'),
            'tipo' => $this->faker->randomElement(['ADMIN', 'PESSOA']),
        ];
    }
}
