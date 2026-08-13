<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Application\UseCases;

use Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface;
use Src\Academic\Atestado\Domain\Entities\Atestado;

final class ListAtestadosUseCase
{
    public function __construct(private readonly AtestadoRepositoryInterface $repository) {}

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->all($search, $sortBy, $sortDir);
    }

    public function paginate(?string $search = null, int $perPage = 10, int $page = 1, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        return $this->repository->paginate($search, $perPage, $page, $sortBy, $sortDir);
    }
}