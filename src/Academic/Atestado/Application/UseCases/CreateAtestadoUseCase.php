<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Application\UseCases;

use Src\Academic\Atestado\Application\DTOs\AtestadoDTO;
use Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface;
use Src\Academic\Atestado\Domain\Entities\Atestado;

final class CreateAtestadoUseCase
{
    public function __construct(private readonly AtestadoRepositoryInterface $repository) {}

    public function handle(AtestadoDTO $dto): Atestado
    {
        $atestado = Atestado::create(
            docenteId: $dto->docenteId,
            grado: $dto->grado,
            institucion: $dto->institucion,
            anioObtencion: $dto->anioObtencion,
            areaEspecializacion: $dto->areaEspecializacion,
        );
        return $this->repository->save($atestado);
    }
}