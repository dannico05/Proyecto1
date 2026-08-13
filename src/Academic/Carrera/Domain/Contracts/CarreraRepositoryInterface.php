<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Domain\Contracts;

use Src\Academic\Carrera\Domain\Entities\Carrera;

interface CarreraRepositoryInterface
{
    public function find(int $id): ?Carrera;
    public function save(Carrera $carrera): Carrera;
    public function delete(int $id): void;
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array;
    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array;
}