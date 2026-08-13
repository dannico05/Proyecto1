<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Application\DTOs;

/**
 * Immutable data boundary between Presentation and Application layers.
 * Carries primitives only — no Domain Entities and no Eloquent Models
 * leak across this line in either direction.
 */
final readonly class DocenteDTO
{
    public function __construct(
        public string $name,
        public string $governmentID,
        public string $lastName,
    ) {
    }

    /**
     * @param array{name: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            governmentID: $data['governmentID'],
            lastName: $data['lastName'],

        );
    }
}
