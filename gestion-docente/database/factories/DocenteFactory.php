<?php

namespace Database\Factories;

use App\Models\Docente;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocenteFactory extends Factory
{
    protected $model = Docente::class;

    public function definition(): array
    {
        return [
            'cedula' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'user_id' => null,
        ];
    }
}