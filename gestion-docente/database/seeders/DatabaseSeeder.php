<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Atestado;
use App\Models\CatalogoVersion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear la carrera
        $carrera = Carrera::factory()->create([
            'codigo' => 'ISC',
            'nombre' => 'Ingeniería en Sistemas'
        ]);

        // 2. Crear el curso
        $curso = Curso::factory()->create([
            'codigo' => 'ISW-521',
            'nombre' => 'Programación Web I',
            'creditos' => 4
        ]);

        // 3. Crear un docente
        $docente = Docente::factory()->create([
            'cedula' => '123456789',
            'nombre' => 'Bryan',
            'apellido' => 'Chaves'
        ]);

        // 4. Crear un atestado para ese docente
        Atestado::factory()->create([
            'docente_id' => $docente->id,
            'grado' => 'Maestría',
            'institucion' => 'UTN',
            'anio_obtencion' => 2020,
            'area_especializacion' => 'Ingeniería de Software'
        ]);

        // 5. Crear la entrada del catálogo versionado
        CatalogoVersion::factory()->create([
            'carrera_id' => $carrera->id,
            'curso_id' => $curso->id,
            'version' => 1,
            'acuerdo' => 'ACU-2026-001',
            'gaceta' => 'GAC-2026-001',
            'grados_atinentes' => json_encode(['Maestría', 'Licenciatura en Computación']),
            'fecha_inicio_vigencia' => '2026-01-01',
            'fecha_fin_vigencia' => '2026-12-31',
        ]);
    }
}