<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Academic\Atestado\Presentation\Livewire\AtestadoComponent;

Route::middleware(['web', 'auth', 'verified'])
    ->get('atestados', AtestadoComponent::class)
    ->name('academic.atestado.index');