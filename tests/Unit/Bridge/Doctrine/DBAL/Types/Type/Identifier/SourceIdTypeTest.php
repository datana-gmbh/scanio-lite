<?php

declare(strict_types=1);

namespace App\Tests\Unit\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\SourceIdType;
use App\Domain\Identifier\SourceId;
use Datana\Doctrine\Testcase\UidTypeTestCase;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\AbstractUid;

final class SourceIdTypeTest extends UidTypeTestCase
{
    /**
     * @return SourceIdType
     */
    protected static function createType(): Type
    {
        return new SourceIdType();
    }

    protected static function name(): string
    {
        return SourceIdType::class;
    }

    /**
     * @return SourceId
     */
    protected static function createId(): AbstractUid
    {
        return new SourceId();
    }
}
