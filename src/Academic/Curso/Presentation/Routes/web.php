<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Academic\Curso\Presentation\Livewire\CursoComponent;

Route::middleware(['web', 'auth', 'verified'])
    ->get('cursos', CursoComponent::class)
    ->name('academic.curso.index');