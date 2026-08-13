<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\UseCases;

use Src\Academic\Carrera\Application\DTOs\CarreraDTO;
use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Entities\Carrera;
use Src\Academic\Carrera\Domain\Exceptions\CarreraNotFoundException;

final class UpdateCarreraUseCase
{
    public function __construct(private readonly CarreraRepositoryInterface $repository) {}

    public function handle(int $id, CarreraDTO $dto): Carrera
    {
        $carrera = $this->repository->find($id) ?? throw CarreraNotFoundException::withId($id);
        $carrera->setCodigo($dto->codigo);
        $carrera->setNombre($dto->nombre);
        return $this->repository->save($carrera);
    }
}