<?php

declare(strict_types=1);

namespace App\Tests\Unit\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\EmailIdType;
use App\Domain\Identifier\EmailId;
use Datana\Doctrine\Testcase\UidTypeTestCase;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\AbstractUid;

final class EmailIdTypeTest extends UidTypeTestCase
{
    /**
     * @return EmailIdType
     */
    protected static function createType(): Type
    {
        return new EmailIdType();
    }

    protected static function name(): string
    {
        return EmailIdType::class;
    }

    /**
     * @return EmailId
     */
    protected static function createId(): AbstractUid
    {
        return new EmailId();
    }
}
