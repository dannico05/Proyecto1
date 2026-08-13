<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Domain\Entities;

use DateTimeInterface;

final class CatalogoVersion
{
    private function __construct(
        private readonly ?int $id,
        private int $carreraId,
        private int $cursoId,
        private int $version,
        private string $acuerdo,
        private string $gaceta,
        private array $gradosAtinentes,
        private DateTimeInterface $fechaInicioVigencia,
        private ?DateTimeInterface $fechaFinVigencia,
    ) {
    }

    public static function create(
        int $carreraId,
        int $cursoId,
        int $version,
        string $acuerdo,
        string $gaceta,
        array $gradosAtinentes,
        DateTimeInterface $fechaInicioVigencia,
        ?DateTimeInterface $fechaFinVigencia = null,
    ): self {
        return new self(
            id: null,
            carreraId: $carreraId,
            cursoId: $cursoId,
            version: $version,
            acuerdo: $acuerdo,
            gaceta: $gaceta,
            gradosAtinentes: $gradosAtinentes,
            fechaInicioVigencia: $fechaInicioVigencia,
            fechaFinVigencia: $fechaFinVigencia,
        );
    }

    public static function reconstitute(
        int $id,
        int $carreraId,
        int $cursoId,
        int $version,
        string $acuerdo,
        string $gaceta,
        array $gradosAtinentes,
        DateTimeInterface $fechaInicioVigencia,
        ?DateTimeInterface $fechaFinVigencia = null,
    ): self {
        return new self(
            id: $id,
            carreraId: $carreraId,
            cursoId: $cursoId,
            version: $version,
            acuerdo: $acuerdo,
            gaceta: $gaceta,
            gradosAtinentes: $gradosAtinentes,
            fechaInicioVigencia: $fechaInicioVigencia,
            fechaFinVigencia: $fechaFinVigencia,
        );
    }

    // Setters
    public function setCarreraId(int $carreraId): void { $this->carreraId = $carreraId; }
    public function setCursoId(int $cursoId): void { $this->cursoId = $cursoId; }
    public function setVersion(int $version): void { $this->version = $version; }
    public function setAcuerdo(string $acuerdo): void { $this->acuerdo = $acuerdo; }
    public function setGaceta(string $gaceta): void { $this->gaceta = $gaceta; }
    public function setGradosAtinentes(array $gradosAtinentes): void { $this->gradosAtinentes = $gradosAtinentes; }
    public function setFechaInicioVigencia(DateTimeInterface $fecha): void { $this->fechaInicioVigencia = $fecha; }
    public function setFechaFinVigencia(?DateTimeInterface $fecha): void { $this->fechaFinVigencia = $fecha; }

    // Getters
    public function id(): ?int { return $this->id; }
    public function carreraId(): int { return $this->carreraId; }
    public function cursoId(): int { return $this->cursoId; }
    public function version(): int { return $this->version; }
    public function acuerdo(): string { return $this->acuerdo; }
    public function gaceta(): string { return $this->gaceta; }
    public function gradosAtinentes(): array { return $this->gradosAtinentes; }
    public function fechaInicioVigencia(): DateTimeInterface { return $this->fechaInicioVigencia; }
    public function fechaFinVigencia(): ?DateTimeInterface { return $this->fechaFinVigencia; }
}