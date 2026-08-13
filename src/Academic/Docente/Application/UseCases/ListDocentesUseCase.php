<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\UseCases;

use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;
use Src\Academic\Docente\Domain\Entities\Docente;

final class ListDocentesUseCase
{
    public function __construct(
        private readonly DocenteRepositoryInterface $repository,
    ) {}

    /** @return array<int, Docente> */
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->all($search, $sortBy, $sortDir);
    }

    /** @return array{items: array<int, Docente>, total: int} */
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