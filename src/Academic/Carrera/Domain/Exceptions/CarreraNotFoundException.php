<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Domain\Exceptions;

use DomainException;

final class CarreraNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self("Carrera with id [{$id}] was not found.");
    }
}