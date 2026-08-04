<?php

namespace Database\Factories;

use App\Models\Atestado;
use App\Models\Docente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Atestado>
 */
class AtestadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'docente_id' => Docente::factory(), // Relación automática
            'grado' => fake()->randomElement(['Bachillerato', 'Licenciatura', 'Maestría', 'Doctorado']),
            'institucion' => fake()->company(),
            'anio_obtencion' => fake()->year(),
            'area_especializacion' => fake()->word(),
        ];
    }
}
