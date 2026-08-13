<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Application\UseCases;

use Src\Academic\CatalogoVersion\Application\DTOs\CatalogoVersionDTO;
use Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;

final class CreateCatalogoVersionUseCase
{
    public function __construct(private readonly CatalogoVersionRepositoryInterface $repository) {}

    public function handle(CatalogoVersionDTO $dto): CatalogoVersion
    {
        $catalogo = CatalogoVersion::create(
            carreraId: $dto->carreraId,
            cursoId: $dto->cursoId,
            version: $dto->version,
            acuerdo: $dto->acuerdo,
            gaceta: $dto->gaceta,
            gradosAtinentes: $dto->gradosAtinentes,
            fechaInicioVigencia: $dto->fechaInicioVigencia,
            fechaFinVigencia: $dto->fechaFinVigencia,
        );
        return $this->repository->save($catalogo);
    }
}