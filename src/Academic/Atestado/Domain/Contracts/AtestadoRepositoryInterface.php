<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Domain\Contracts;

use Src\Academic\Atestado\Domain\Entities\Atestado;

interface AtestadoRepositoryInterface
{
    public function find(int $id): ?Atestado;
    public function save(Atestado $atestado): Atestado;
    public function delete(int $id): void;
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array;
    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array;
}