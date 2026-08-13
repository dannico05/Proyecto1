<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Academic\Docente\Presentation\Livewire\DocenteComponent;

Route::middleware(['web', 'auth', 'verified'])
    ->get('docentes', DocenteComponent::class)
    ->name('academic.docente.index');