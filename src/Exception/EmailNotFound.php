<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\EmailId;

final class EmailNotFound extends NotFoundException
{
    public static function withId(EmailId $id): self
    {
        return new self(sprintf(
            'Cannot find Email with id: %s',
            $id->toString(),
        ));
    }
}
