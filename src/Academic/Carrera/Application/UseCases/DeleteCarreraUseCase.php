<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\UseCases;

use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Exceptions\CarreraNotFoundException;

final class DeleteCarreraUseCase
{
    public function __construct(private readonly CarreraRepositoryInterface $repository) {}

    public function handle(int $id): void
    {
        $this->repository->find($id) ?? throw CarreraNotFoundException::withId($id);
        $this->repository->delete($id);
    }
}