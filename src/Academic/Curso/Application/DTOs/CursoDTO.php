<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Application\DTOs;

final readonly class CursoDTO
{
    public function __construct(
        public string $codigo,
        public string $nombre,
        public ?int $creditos,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codigo: $data['codigo'],
            nombre: $data['nombre'],
            creditos: $data['creditos'] ?? null,
        );
    }
}