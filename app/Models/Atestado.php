<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Atestado extends Model
{
    use HasFactory;
    protected $fillable = ['docente_id', 'grado', 'institucion', 'anio_obtencion', 'area_especializacion'];
}
