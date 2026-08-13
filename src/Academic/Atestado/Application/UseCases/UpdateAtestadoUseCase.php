<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Application\UseCases;

use Src\Academic\Atestado\Application\DTOs\AtestadoDTO;
use Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface;
use Src\Academic\Atestado\Domain\Entities\Atestado;
use Src\Academic\Atestado\Domain\Exceptions\AtestadoNotFoundException;

final class UpdateAtestadoUseCase
{
    public function __construct(private readonly AtestadoRepositoryInterface $repository) {}

    public function handle(int $id, AtestadoDTO $dto): Atestado
    {
        $atestado = $this->repository->find($id) ?? throw AtestadoNotFoundException::withId($id);
        $atestado->setDocenteId($dto->docenteId);
        $atestado->setGrado($dto->grado);
        $atestado->setInstitucion($dto->institucion);
        $atestado->setAnioObtencion($dto->anioObtencion);
        $atestado->setAreaEspecializacion($dto->areaEspecializacion);
        return $this->repository->save($atestado);
    }
}