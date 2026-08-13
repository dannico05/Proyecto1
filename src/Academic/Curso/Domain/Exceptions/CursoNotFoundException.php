<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Domain\Exceptions;

use DomainException;

final class CursoNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self("Curso with id [{$id}] was not found.");
    }
}