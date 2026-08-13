<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Presentation\Policies;

use App\Models\User;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;

class CatalogoVersionPolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('catalogo_versiones.view'); }
    public function view(User $user, CatalogoVersion $catalogo): bool { return $user->hasPermissionTo('catalogo_versiones.view'); }
    public function search(User $user): bool { return $user->hasPermissionTo('catalogo_versiones.search'); }
    public function create(User $user): bool { return $user->hasPermissionTo('catalogo_versiones.create'); }
    public function update(User $user, CatalogoVersion $catalogo): bool { return $user->hasPermissionTo('catalogo_versiones.edit'); }
    public function delete(User $user, CatalogoVersion $catalogo): bool { return $user->hasPermissionTo('catalogo_versiones.delete'); }
    public function exportPdf(User $user): bool { return $user->hasPermissionTo('catalogo_versiones.export_pdf'); }
    public function exportExcel(User $user): bool { return $user->hasPermissionTo('catalogo_versiones.export_excel'); }
}