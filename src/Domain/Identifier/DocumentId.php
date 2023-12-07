<?php

declare(strict_types=1);

namespace App\Domain\Identifier;

use App\Domain\Identifier\Traits\IdTrait;
use Symfony\Component\Uid\Ulid;

final class DocumentId extends Ulid
{
    use IdTrait;
}
