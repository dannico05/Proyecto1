<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Application\UseCases;

use Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface;
use Src\Academic\CatalogoVersion\Domain\Exceptions\CatalogoVersionNotFoundException;

final class DeleteCatalogoVersionUseCase
{
    public function __construct(private readonly CatalogoVersionRepositoryInterface $repository) {}

    public function handle(int $id): void
    {
        $this->repository->find($id) ?? throw CatalogoVersionNotFoundException::withId($id);
        $this->repository->delete($id);
    }
}