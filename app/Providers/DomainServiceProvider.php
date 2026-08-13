<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;

final class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    private array $domainBindings = [
        // IdentityAccess (del profesor)
        \Src\IdentityAccess\Role\Domain\Contracts\RoleRepositoryInterface::class
        => \Src\IdentityAccess\Role\Infrastructure\Persistence\Repositories\EloquentRoleRepository::class,
        \Src\IdentityAccess\Permission\Domain\Contracts\PermissionRepositoryInterface::class
        => \Src\IdentityAccess\Permission\Infrastructure\Persistence\Repositories\EloquentPermissionRepository::class,

        // Shared (del profesor)
        \Src\Shared\Export\Contracts\ExcelExporterInterface::class
        => \Src\Shared\Export\Infrastructure\SpatieExcelExporter::class,
        \Src\Shared\Export\Contracts\PdfExporterInterface::class
        => \Src\Shared\Export\Infrastructure\SpatiePdfExporter::class,

        // Academic (TUS CRUDs)
        \Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface::class
        => \Src\Academic\Docente\Infrastructure\Persistence\Repositories\EloquentDocenteRepository::class,
        \Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface::class
        => \Src\Academic\Curso\Infrastructure\Persistence\Repositories\EloquentCursoRepository::class,
        \Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface::class
        => \Src\Academic\Carrera\Infrastructure\Persistence\Repositories\EloquentCarreraRepository::class,
        \Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface::class
        => \Src\Academic\Atestado\Infrastructure\Persistence\Repositories\EloquentAtestadoRepository::class,
        \Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface::class
        => \Src\Academic\CatalogoVersion\Infrastructure\Persistence\Repositories\EloquentCatalogoVersionRepository::class,
    ];

    /**
     * @var array<class-string, class-string>
     */
    private array $domainPolicies = [
        // IdentityAccess (del profesor)
        \Src\IdentityAccess\Role\Domain\Entities\Role::class
        => \Src\IdentityAccess\Role\Presentation\Policies\RolePolicy::class,
        \Src\IdentityAccess\Permission\Domain\Entities\Permission::class
        => \Src\IdentityAccess\Permission\Presentation\Policies\PermissionPolicy::class,

        // Academic (TUS CRUDs)
        \Src\Academic\Docente\Domain\Entities\Docente::class
        => \Src\Academic\Docente\Presentation\Policies\DocentePolicy::class,
        \Src\Academic\Curso\Domain\Entities\Curso::class
        => \Src\Academic\Curso\Presentation\Policies\CursoPolicy::class,
        \Src\Academic\Carrera\Domain\Entities\Carrera::class
        => \Src\Academic\Carrera\Presentation\Policies\CarreraPolicy::class,
        \Src\Academic\Atestado\Domain\Entities\Atestado::class
        => \Src\Academic\Atestado\Presentation\Policies\AtestadoPolicy::class,
        \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class
        => \Src\Academic\CatalogoVersion\Presentation\Policies\CatalogoVersionPolicy::class,
    ];

    public function register(): void
    {
        foreach ($this->domainBindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerSuperAdminBypass();
        $this->loadContextRoutes();
        $this->registerLivewireComponents();
    }

    private function registerPolicies(): void
    {
        foreach ($this->domainPolicies as $entity => $policy) {
            Gate::policy($entity, $policy);
        }
    }

    private function registerSuperAdminBypass(): void
    {
        Gate::before(function (Authenticatable $user): ?bool {
            return method_exists($user, 'hasRole') && $user->hasRole('Superadmin')
                ? true
                : null;
        });
    }

    private function loadContextRoutes(): void
    {
        if (app()->routesAreCached()) {
            return;
        }

        foreach (File::glob(base_path('src/*/*/Presentation/Routes/web.php')) as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }

    private function registerLivewireComponents(): void
    {
        // IdentityAccess (del profesor)
        \Livewire\Livewire::component('role-component', \Src\IdentityAccess\Role\Presentation\Livewire\RoleComponent::class);
        \Livewire\Livewire::component('permission-component', \Src\IdentityAccess\Permission\Presentation\Livewire\PermissionComponent::class);

        // Academic (TUS CRUDs)
        \Livewire\Livewire::component('docente-component', \Src\Academic\Docente\Presentation\Livewire\DocenteComponent::class);
        \Livewire\Livewire::component('curso-component', \Src\Academic\Curso\Presentation\Livewire\CursoComponent::class);
        \Livewire\Livewire::component('carrera-component', \Src\Academic\Carrera\Presentation\Livewire\CarreraComponent::class);
        \Livewire\Livewire::component('atestado-component', \Src\Academic\Atestado\Presentation\Livewire\AtestadoComponent::class);
        \Livewire\Livewire::component('catalogo-version-component', \Src\Academic\CatalogoVersion\Presentation\Livewire\CatalogoVersionComponent::class);
    }
}