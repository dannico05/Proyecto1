<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Academic\Carrera\Presentation\Livewire\CarreraComponent;

Route::middleware(['web', 'auth', 'verified'])
    ->get('carreras', CarreraComponent::class)
    ->name('academic.carrera.index');