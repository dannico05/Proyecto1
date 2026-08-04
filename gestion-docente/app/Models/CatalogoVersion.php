<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoVersion extends Model
{
    use HasFactory;

    protected $table = 'catalogo_versiones';

    // para que el JSON se convierta en array cuando se lea
    protected $casts = [
        'grados_atinentes' => 'array',
    ];

    protected $fillable = [
        'carrera_id',
        'curso_id',
        'version',
        'acuerdo',
        'gaceta',
        'grados_atinentes',
        'fecha_inicio_vigencia',
        'fecha_fin_vigencia',
    ];

    // Relaciones 
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}