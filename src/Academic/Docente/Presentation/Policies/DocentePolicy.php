<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Presentation\Policies;

use App\Models\User;
use Src\Academic\Docente\Domain\Entities\Docente;

class DocentePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('docentes.view');
    }

    public function view(User $user, Docente $docente): bool
    {
        return $user->hasPermissionTo('docentes.view');
    }

    public function search(User $user): bool
    {
        return $user->hasPermissionTo('docentes.search');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('docentes.create');
    }

    public function update(User $user, Docente $docente): bool
    {
        return $user->hasPermissionTo('docentes.edit');
    }

    public function delete(User $user, Docente $docente): bool
    {
        return $user->hasPermissionTo('docentes.delete');
    }

    public function exportPdf(User $user): bool
    {
        return $user->hasPermissionTo('docentes.export_pdf');
    }

    public function exportExcel(User $user): bool
    {
        return $user->hasPermissionTo('docentes.export_excel');
    }
}