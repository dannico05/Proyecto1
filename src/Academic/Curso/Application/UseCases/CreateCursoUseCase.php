<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Application\UseCases;

use Src\Academic\Curso\Application\DTOs\CursoDTO;
use Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface;
use Src\Academic\Curso\Domain\Entities\Curso;

final class CreateCursoUseCase
{
    public function __construct(
        private readonly CursoRepositoryInterface $repository,
    ) {
    }

    public function handle(CursoDTO $dto): Curso
    {
        $curso = Curso::create(
            codigo: $dto->codigo,
            nombre: $dto->nombre,
            creditos: $dto->creditos,
        );

        return $this->repository->save($curso);
    }
}