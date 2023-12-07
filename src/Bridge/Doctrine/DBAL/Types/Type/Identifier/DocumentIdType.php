<?php

declare(strict_types=1);

namespace App\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Domain\Identifier\DocumentId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DocumentIdType extends AbstractUidType
{
    public function getName(): string
    {
        return self::class;
    }

    protected function getUidClass(): string
    {
        return DocumentId::class;
    }
}
