<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\LetterId;

final class LetterNotFound extends NotFoundException
{
    public static function withId(LetterId $id): self
    {
        return new self(sprintf(
            'Cannot find Letter with id: %s',
            $id->toString(),
        ));
    }
}