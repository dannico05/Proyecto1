<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Domain\Entities;

final class Carrera
{
    private function __construct(
        private readonly ?int $id,
        private string $codigo,
        private string $nombre,
    ) {
    }

    public static function create(string $codigo, string $nombre): self
    {
        return new self(id: null, codigo: $codigo, nombre: $nombre);
    }

    public static function reconstitute(int $id, string $codigo, string $nombre): self
    {
        return new self(id: $id, codigo: $codigo, nombre: $nombre);
    }

    public function setCodigo(string $codigo): void { $this->codigo = $codigo; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function id(): ?int { return $this->id; }
    public function codigo(): string { return $this->codigo; }
    public function nombre(): string { return $this->nombre; }
}