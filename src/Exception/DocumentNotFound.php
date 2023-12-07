<?php

declare(strict_types=1);

namespace App\Exception;

use App\Domain\Identifier\DocumentId;

final class DocumentNotFound extends NotFoundException
{
    public static function withId(DocumentId $id): self
    {
        return new self(sprintf(
            'Cannot find Document with id: %s',
            $id->toString(),
        ));
    }
}
