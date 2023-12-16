<?php

declare(strict_types=1);

namespace App\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Domain\Identifier\EmailId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class EmailIdType extends AbstractUidType
{
    public function getName(): string
    {
        return self::class;
    }

    protected function getUidClass(): string
    {
        return EmailId::class;
    }
}
