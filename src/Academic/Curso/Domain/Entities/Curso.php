<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Domain\Entities;

final class Curso
{
    private function __construct(
        private readonly ?int $id,
        private string $codigo,
        private string $nombre,
        private ?int $creditos,
    ) {
    }

    public static function create(string $codigo, string $nombre, ?int $creditos): self
    {
        return new self(id: null, codigo: $codigo, nombre: $nombre, creditos: $creditos);
    }

    public static function reconstitute(int $id, string $codigo, string $nombre, ?int $creditos): self
    {
        return new self(id: $id, codigo: $codigo, nombre: $nombre, creditos: $creditos);
    }

    // Métodos mutadores con validaciones
    public function setCodigo(string $codigo): void
    {
        // Aquí podrías agregar validaciones (ej: formato XXX-###)
        $this->codigo = $codigo;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setCreditos(?int $creditos): void
    {
        $this->creditos = $creditos;
    }

    // Getters
    public function id(): ?int { return $this->id; }
    public function codigo(): string { return $this->codigo; }
    public function nombre(): string { return $this->nombre; }
    public function creditos(): ?int { return $this->creditos; }
}