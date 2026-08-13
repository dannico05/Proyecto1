<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Domain\Entities;

final class Atestado
{
    private function __construct(
        private readonly ?int $id,
        private int $docenteId,
        private string $grado,
        private string $institucion,
        private int $anioObtencion,
        private string $areaEspecializacion,
    ) {
    }

    public static function create(
        int $docenteId,
        string $grado,
        string $institucion,
        int $anioObtencion,
        string $areaEspecializacion,
    ): self {
        return new self(
            id: null,
            docenteId: $docenteId,
            grado: $grado,
            institucion: $institucion,
            anioObtencion: $anioObtencion,
            areaEspecializacion: $areaEspecializacion,
        );
    }

    public static function reconstitute(
        int $id,
        int $docenteId,
        string $grado,
        string $institucion,
        int $anioObtencion,
        string $areaEspecializacion,
    ): self {
        return new self(
            id: $id,
            docenteId: $docenteId,
            grado: $grado,
            institucion: $institucion,
            anioObtencion: $anioObtencion,
            areaEspecializacion: $areaEspecializacion,
        );
    }

    public function setDocenteId(int $docenteId): void { $this->docenteId = $docenteId; }
    public function setGrado(string $grado): void { $this->grado = $grado; }
    public function setInstitucion(string $institucion): void { $this->institucion = $institucion; }
    public function setAnioObtencion(int $anioObtencion): void { $this->anioObtencion = $anioObtencion; }
    public function setAreaEspecializacion(string $areaEspecializacion): void { $this->areaEspecializacion = $areaEspecializacion; }

    public function id(): ?int { return $this->id; }
    public function docenteId(): int { return $this->docenteId; }
    public function grado(): string { return $this->grado; }
    public function institucion(): string { return $this->institucion; }
    public function anioObtencion(): int { return $this->anioObtencion; }
    public function areaEspecializacion(): string { return $this->areaEspecializacion; }
}