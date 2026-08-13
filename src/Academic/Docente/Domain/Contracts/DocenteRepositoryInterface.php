<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Domain\Contracts;

use Src\Academic\Docente\Domain\Entities\Docente;

/**
 * Port (in the Hexagonal sense) that Infrastructure adapters must
 * implement. The Domain and Application layers depend only on this
 * abstraction — never on Eloquent, the database, or any concrete driver.
 */
interface DocenteRepositoryInterface
{
    public function find(int $id): ?Docente;

    public function save(Docente $docente): Docente;

    public function delete(int $id): void;

    /** @return array<int, Docente> */
    public function all(?string $sortBy = null, string $sortDir = 'asc'): array;

    /** @return array{items: array<int, Docente>, total: int} */
    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array;
}
