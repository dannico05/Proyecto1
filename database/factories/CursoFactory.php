<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => fake()->unique()->bothify('???-###'), // Ej: "ISW-521"
            'nombre' => fake()->sentence(2),
            'creditos' => fake()->numberBetween(2, 4),
        ];
    }
}
