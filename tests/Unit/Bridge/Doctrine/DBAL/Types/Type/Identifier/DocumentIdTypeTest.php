<?php

declare(strict_types=1);

namespace App\Tests\Unit\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\DocumentIdType;
use App\Domain\Identifier\DocumentId;
use Datana\Doctrine\Testcase\UidTypeTestCase;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\AbstractUid;

final class DocumentIdTypeTest extends UidTypeTestCase
{
    /**
     * @return DocumentIdType
     */
    protected static function createType(): Type
    {
        return new DocumentIdType();
    }

    protected static function name(): string
    {
        return DocumentIdType::class;
    }

    /**
     * @return DocumentId
     */
    protected static function createId(): AbstractUid
    {
        return new DocumentId();
    }
}
