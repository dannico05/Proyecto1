<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Presentation\Policies;

use App\Models\User;
use Src\Academic\Carrera\Domain\Entities\Carrera;

class CarreraPolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('carreras.view'); }
    public function view(User $user, Carrera $carrera): bool { return $user->hasPermissionTo('carreras.view'); }
    public function search(User $user): bool { return $user->hasPermissionTo('carreras.search'); }
    public function create(User $user): bool { return $user->hasPermissionTo('carreras.create'); }
    public function update(User $user, Carrera $carrera): bool { return $user->hasPermissionTo('carreras.edit'); }
    public function delete(User $user, Carrera $carrera): bool { return $user->hasPermissionTo('carreras.delete'); }
    public function exportPdf(User $user): bool { return $user->hasPermissionTo('carreras.export_pdf'); }
    public function exportExcel(User $user): bool { return $user->hasPermissionTo('carreras.export_excel'); }
}