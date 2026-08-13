<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Application\UseCases;

use Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface;
use Src\Academic\Curso\Domain\Entities\Curso;

final class ListCursosUseCase
{
    public function __construct(
        private readonly CursoRepositoryInterface $repository,
    ) {
    }

    /** @return array<int, Curso> */
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->all($search, $sortBy, $sortDir);
    }

    /** @return array{items: array<int, Curso>, total: int} */
    public function paginate(
        ?string $search = null,
        int $perPage = 10,
        int $page = 1,
        ?string $sortBy = null,
        string $sortDir = 'asc',
    ): array {
        return $this->repository->paginate($search, $perPage, $page, $sortBy, $sortDir);
    }
}