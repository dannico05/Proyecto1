<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Domain\Contracts;

use Src\Academic\Curso\Domain\Entities\Curso;

interface CursoRepositoryInterface
{
    public function find(int $id): ?Curso;
    public function save(Curso $curso): Curso;
    public function delete(int $id): void;
    
    /** @return array<int, Curso> */
    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array;
    
    /** @return array{items: array<int, Curso>, total: int} */
    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array;
}