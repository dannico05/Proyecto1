<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Domain\Entities;

/**
 * Docente — Aggregate Root of the Academic bounded context.
 *
 * Pure PHP. Zero framework coupling — no Eloquent, no Illuminate imports.
 * This class is the single source of truth for Docente business
 * invariants. Persistence concerns belong to Infrastructure, not here.
 */
final class Docente
{
    private function __construct(
        private readonly ?int $id,
        private string $name,
        private string $governmentID,
        private string $lastName,
    ) {
    }

    /**
     * Factory for a brand-new Docente (no identity yet).
     */
    public static function create(string $name, string $governmentID, string $lastName): self
    {
        return new self(id: null, name: $name, governmentID: $governmentID, lastName: $lastName);
    }

    /**
     * Factory used exclusively by the Infrastructure layer to rehydrate
     * a Docente from a persisted record.
     */
    public static function reconstitute(int $id, string $name, string $governmentID, string $lastName): self
    {
        return new self(id: $id, name: $name, governmentID: $governmentID, lastName: $lastName);
    }

    public function rename(string $name): void
    {
        // Add invariants here (length, format, uniqueness delegated to a
        // domain service, etc.) before mutating state.
        $this->name = $name;
    }

    public function setGovernmentID(string $governmentID): void
    {
         $this->governmentID = $governmentID;
    }

    public function setLastName(string $lastName): void
    {
     
        $this->lastName = $lastName;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function governmentID(): string
    {
        return $this->governmentID;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }
}
