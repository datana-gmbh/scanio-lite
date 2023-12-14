<?php

declare(strict_types=1);

namespace App\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Domain\Identifier\StorageId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class StorageIdType extends AbstractUidType
{
    public function getName(): string
    {
        return self::class;
    }

    protected function getUidClass(): string
    {
        return StorageId::class;
    }
}
