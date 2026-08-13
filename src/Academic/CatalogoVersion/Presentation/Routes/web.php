<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Academic\CatalogoVersion\Presentation\Livewire\CatalogoVersionComponent;

Route::middleware(['web', 'auth', 'verified'])
    ->get('catalogo-version', CatalogoVersionComponent::class)
    ->name('academic.catalogo-version.index');