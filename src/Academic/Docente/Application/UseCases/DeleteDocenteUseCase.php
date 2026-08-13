<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\UseCases;

use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;

final class DeleteDocenteUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $repository,
    ) {}

    public function handle(int $id): void
    {
        $this->repository->find($id) ?? throw \Src\Academic\Docente\Domain\Exceptions\DocenteNotFoundException::withId($id);

        $this->repository->delete($id);
    }
}