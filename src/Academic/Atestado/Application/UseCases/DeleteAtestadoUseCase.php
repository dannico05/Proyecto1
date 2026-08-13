<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Application\UseCases;

use Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface;
use Src\Academic\Atestado\Domain\Exceptions\AtestadoNotFoundException;

final class DeleteAtestadoUseCase
{
    public function __construct(private readonly AtestadoRepositoryInterface $repository) {}

    public function handle(int $id): void
    {
        $this->repository->find($id) ?? throw AtestadoNotFoundException::withId($id);
        $this->repository->delete($id);
    }
}