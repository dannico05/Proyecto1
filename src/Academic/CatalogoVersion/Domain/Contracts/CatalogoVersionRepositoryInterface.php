<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Domain\Contracts;

use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;

interface CatalogoVersionRepositoryInterface
{
    public function find(int $id): ?CatalogoVersion;
    public function save(CatalogoVersion $catalogoVersion): CatalogoVersion;
    public function delete(int $id): void;
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array;
    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array;
}