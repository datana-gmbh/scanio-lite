<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\StorageId;

final class StorageNotFound extends NotFoundException
{
    public static function withId(StorageId $id): self
    {
        return new self(sprintf(
            'Cannot find Storage with id: %s',
            $id->toString(),
        ));
    }
}
