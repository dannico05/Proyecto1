<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Presentation\Policies;

use App\Models\User;
use Src\Academic\Curso\Domain\Entities\Curso;

class CursoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('cursos.view');
    }

    public function view(User $user, Curso $curso): bool
    {
        return $user->hasPermissionTo('cursos.view');
    }

    public function search(User $user): bool
    {
        return $user->hasPermissionTo('cursos.search');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('cursos.create');
    }

    public function update(User $user, Curso $curso): bool
    {
        return $user->hasPermissionTo('cursos.edit');
    }

    public function delete(User $user, Curso $curso): bool
    {
        return $user->hasPermissionTo('cursos.delete');
    }

    public function exportPdf(User $user): bool
    {
        return $user->hasPermissionTo('cursos.export_pdf');
    }

    public function exportExcel(User $user): bool
    {
        return $user->hasPermissionTo('cursos.export_excel');
    }
}