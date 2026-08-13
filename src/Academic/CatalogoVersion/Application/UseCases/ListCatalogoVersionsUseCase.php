<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Application\UseCases;

use Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;

final class ListCatalogoVersionsUseCase
{
    public function __construct(private readonly CatalogoVersionRepositoryInterface $repository) {}

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->all($search, $sortBy, $sortDir);
    }

    public function paginate(?string $search = null, int $perPage = 10, int $page = 1, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->paginate($search, $perPage, $page, $sortBy, $sortDir);
    }
}