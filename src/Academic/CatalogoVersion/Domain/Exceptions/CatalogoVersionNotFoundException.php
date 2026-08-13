<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Domain\Exceptions;

use DomainException;

final class CatalogoVersionNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self("CatalogoVersion with id [{$id}] was not found.");
    }
}