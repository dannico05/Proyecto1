<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\UseCases;

use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;
use Src\Academic\Docente\Domain\Entities\Docente;
use Src\Academic\Docente\Domain\Exceptions\DocenteNotFoundException;

final class FindDocenteUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $repository,
    ) {}

    public function handle(int $id): Docente
    {
        return $this->repository->find($id) ?? throw DocenteNotFoundException::withId($id);
    }
}