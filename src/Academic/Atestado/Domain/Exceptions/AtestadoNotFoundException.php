<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Domain\Exceptions;

use DomainException;

final class AtestadoNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self("Atestado with id [{$id}] was not found.");
    }
}