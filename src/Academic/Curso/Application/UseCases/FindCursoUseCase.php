<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Application\UseCases;

use Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface;
use Src\Academic\Curso\Domain\Entities\Curso;
use Src\Academic\Curso\Domain\Exceptions\CursoNotFoundException;

final class FindCursoUseCase
{
    public function __construct(
        private readonly CursoRepositoryInterface $repository,
    ) {
    }

    public function handle(int $id): Curso
    {
        return $this->repository->find($id) ?? throw CursoNotFoundException::withId($id);
    }
}