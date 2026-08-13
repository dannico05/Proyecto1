<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\UseCases;

use Src\Academic\Docente\Application\DTOs\DocenteDTO;
use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;
use Src\Academic\Docente\Domain\Entities\Docente;
use Src\Academic\Docente\Domain\Exceptions\DocenteNotFoundException;

/**
 * Single-purpose orchestrator (SRP): turns a RoleDTO into a
 * persisted Role. Depends on the repository abstraction only —
 * the concrete EloquentRoleRepository is wired in by the container
 * (see App\Providers\DomainServiceProvider) and never instantiated here.
 */
final class UpdateDocenteUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $repository,
    ) {}

    public function handle(int $id, DocenteDTO $dto): Docente
    {
        $docente = $this->repository->find($id) ?? throw DocenteNotFoundException::withId($id);

        $docente->rename($dto->name);
        $docente->setGovernmentID($dto->governmentID);
        $docente->setLastName($dto->lastName);
        //$Docente->syncPermissions($dto->permissions);

        return $this->repository->save($docente);
    }
}
