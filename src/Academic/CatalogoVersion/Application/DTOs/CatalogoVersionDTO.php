<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Application\DTOs;

use DateTimeInterface;

final readonly class CatalogoVersionDTO
{
    public function __construct(
        public int $carreraId,
        public int $cursoId,
        public int $version,
        public string $acuerdo,
        public string $gaceta,
        public array $gradosAtinentes,
        public DateTimeInterface $fechaInicioVigencia,
        public ?DateTimeInterface $fechaFinVigencia,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            carreraId: (int) $data['carrera_id'],
            cursoId: (int) $data['curso_id'],
            version: (int) $data['version'],
            acuerdo: $data['acuerdo'],
            gaceta: $data['gaceta'],
            gradosAtinentes: $data['grados_atinentes'] ?? [],
            fechaInicioVigencia: new \DateTimeImmutable($data['fecha_inicio_vigencia']),
            fechaFinVigencia: isset($data['fecha_fin_vigencia']) ? new \DateTimeImmutable($data['fecha_fin_vigencia']) : null,
        );
    }
}