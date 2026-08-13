<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Application\UseCases;

use Src\Academic\CatalogoVersion\Application\DTOs\CatalogoVersionDTO;
use Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;
use Src\Academic\CatalogoVersion\Domain\Exceptions\CatalogoVersionNotFoundException;

final class UpdateCatalogoVersionUseCase
{
    public function __construct(private readonly CatalogoVersionRepositoryInterface $repository) {}

    public function handle(int $id, CatalogoVersionDTO $dto): CatalogoVersion
    {
        $catalogo = $this->repository->find($id) ?? throw CatalogoVersionNotFoundException::withId($id);
        $catalogo->setCarreraId($dto->carreraId);
        $catalogo->setCursoId($dto->cursoId);
        $catalogo->setVersion($dto->version);
        $catalogo->setAcuerdo($dto->acuerdo);
        $catalogo->setGaceta($dto->gaceta);
        $catalogo->setGradosAtinentes($dto->gradosAtinentes);
        $catalogo->setFechaInicioVigencia($dto->fechaInicioVigencia);
        $catalogo->setFechaFinVigencia($dto->fechaFinVigencia);
        return $this->repository->save($catalogo);
    }
}