<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\UseCases;

use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Entities\Carrera;
use Src\Academic\Carrera\Domain\Exceptions\CarreraNotFoundException;

final class FindCarreraUseCase
{
    public function __construct(private readonly CarreraRepositoryInterface $repository) {}

    public function handle(int $id): Carrera
    {
        return $this->repository->find($id) ?? throw CarreraNotFoundException::withId($id);
    }
}