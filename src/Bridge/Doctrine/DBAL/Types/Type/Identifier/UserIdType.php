<?php

declare(strict_types=1);

namespace App\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Domain\Identifier\UserId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class UserIdType extends AbstractUidType
{
    public function getName(): string
    {
        return self::class;
    }

    protected function getUidClass(): string
    {
        return UserId::class;
    }
}
