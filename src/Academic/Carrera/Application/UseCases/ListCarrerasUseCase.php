<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\UseCases;

use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Entities\Carrera;

final class ListCarrerasUseCase
{
    public function __construct(private readonly CarreraRepositoryInterface $repository) {}

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->all($search, $sortBy, $sortDir);
    }

    public function paginate(?string $search = null, int $perPage = 10, int $page = 1, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->paginate($search, $perPage, $page, $sortBy, $sortDir);
    }
}