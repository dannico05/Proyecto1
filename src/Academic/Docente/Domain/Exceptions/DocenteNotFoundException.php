<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Domain\Exceptions;

use DomainException;

final class DocenteNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self("Docente with id [{$id}] was not found.");
    }
}