<?php

namespace Database\Factories;

use App\Models\CatalogoVersion;
use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogoVersionFactory extends Factory
{
    protected $model = CatalogoVersion::class;

    public function definition(): array
    {
        return [
            'carrera_id' => Carrera::factory(),
            'curso_id' => Curso::factory(),
            'version' => 1,
            'acuerdo' => 'ACU-' . $this->faker->bothify('##-####'),
            'gaceta' => 'GAC-' . $this->faker->bothify('###-####'),
            'grados_atinentes' => json_encode(['Maestría en Software', 'Licenciatura en Computación']),
            'fecha_inicio_vigencia' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'fecha_fin_vigencia' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}