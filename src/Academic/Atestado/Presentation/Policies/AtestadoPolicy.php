<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Presentation\Policies;

use App\Models\User;
use Src\Academic\Atestado\Domain\Entities\Atestado;

class AtestadoPolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('atestados.view'); }
    public function view(User $user, Atestado $atestado): bool { return $user->hasPermissionTo('atestados.view'); }
    public function search(User $user): bool { return $user->hasPermissionTo('atestados.search'); }
    public function create(User $user): bool { return $user->hasPermissionTo('atestados.create'); }
    public function update(User $user, Atestado $atestado): bool { return $user->hasPermissionTo('atestados.edit'); }
    public function delete(User $user, Atestado $atestado): bool { return $user->hasPermissionTo('atestados.delete'); }
    public function exportPdf(User $user): bool { return $user->hasPermissionTo('atestados.export_pdf'); }
    public function exportExcel(User $user): bool { return $user->hasPermissionTo('atestados.export_excel'); }
}