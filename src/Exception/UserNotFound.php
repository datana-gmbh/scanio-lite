<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\UserId;

final class UserNotFound extends NotFoundException
{
    public static function withId(UserId $id): self
    {
        return new self(sprintf(
            'Cannot find User with id: %s',
            $id->toString(),
        ));
    }
}
