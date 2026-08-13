<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Application\DTOs;

final readonly class CarreraDTO
{
    public function __construct(
        public string $codigo,
        public string $nombre,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codigo: $data['codigo'],
            nombre: $data['nombre'],
        );
    }
}