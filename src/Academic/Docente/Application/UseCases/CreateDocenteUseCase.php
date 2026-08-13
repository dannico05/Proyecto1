<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\UseCases;

use Src\Academic\Docente\Application\DTOs\DocenteDTO;
use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;
use Src\Academic\Docente\Domain\Entities\Docente;

/**
 * Single-purpose orchestrator (SRP): turns a DocenteDTO into a
 * persisted Docente. Depends on the repository abstraction only —
 * the concrete EloquentDocenteRepository is wired in by the container
 * (see App\Providers\DomainServiceProvider) and never instantiated here.
 */
final class CreateDocenteUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $repository,
    ) {
    }

    public function handle(DocenteDTO $dto): Docente
    {
        $docente = Docente::create(
            name: $dto->name,
            governmentID: $dto->governmentID,
            lastName: $dto->lastName,
            
            );

        return $this->repository->save($docente);
    }
}
