<?php

declare(strict_types=1);

namespace App\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Domain\Identifier\SourceId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class SourceIdType extends AbstractUidType
{
    public function getName(): string
    {
        return self::class;
    }

    protected function getUidClass(): string
    {
        return SourceId::class;
    }
}
