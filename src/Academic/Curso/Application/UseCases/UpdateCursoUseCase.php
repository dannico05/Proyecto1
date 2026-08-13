<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Application\UseCases;

use Src\Academic\Curso\Application\DTOs\CursoDTO;
use Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface;
use Src\Academic\Curso\Domain\Entities\Curso;
use Src\Academic\Curso\Domain\Exceptions\CursoNotFoundException;

final class UpdateCursoUseCase
{
    public function __construct(
        private readonly CursoRepositoryInterface $repository,
    ) {
    }

    public function handle(int $id, CursoDTO $dto): Curso
    {
        $curso = $this->repository->find($id) ?? throw CursoNotFoundException::withId($id);

        $curso->setCodigo($dto->codigo);
        $curso->setNombre($dto->nombre);
        $curso->setCreditos($dto->creditos);

        return $this->repository->save($curso);
    }
}