<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\FieldId;

final class FieldNotFound extends NotFoundException
{
    public static function withId(FieldId $id): self
    {
        return new self(sprintf(
            'Cannot find Field with id: %s',
            $id->toString(),
        ));
    }
}
