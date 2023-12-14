<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\SourceId;

final class StorageNotFound extends NotFoundException
{
    public static function withId(SourceId $id): self
    {
        return new self(sprintf(
            'Cannot find Source with id: %s',
            $id->toString(),
        ));
    }
}
