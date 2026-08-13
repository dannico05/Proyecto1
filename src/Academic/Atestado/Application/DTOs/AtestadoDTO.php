<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Application\DTOs;

final readonly class AtestadoDTO
{
    public function __construct(
        public int $docenteId,
        public string $grado,
        public string $institucion,
        public int $anioObtencion,
        public string $areaEspecializacion,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            docenteId: (int) $data['docente_id'],
            grado: $data['grado'],
            institucion: $data['institucion'],
            anioObtencion: (int) $data['anio_obtencion'],
            areaEspecializacion: $data['area_especializacion'],
        );
    }
}