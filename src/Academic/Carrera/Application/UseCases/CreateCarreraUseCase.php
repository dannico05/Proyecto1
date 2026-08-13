<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\UseCases;

use Src\Academic\Carrera\Application\DTOs\CarreraDTO;
use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Entities\Carrera;

final class CreateCarreraUseCase
{
    public function __construct(private readonly CarreraRepositoryInterface $repository) {}

    public function handle(CarreraDTO $dto): Carrera
    {
        $carrera = Carrera::create(codigo: $dto->codigo, nombre: $dto->nombre);
        return $this->repository->save($carrera);
    }
}