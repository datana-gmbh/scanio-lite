<?php

declare(strict_types=1);

namespace App\Tests\Unit\Bridge\Doctrine\DBAL\Types\Type\Identifier;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\UserIdType;
use App\Domain\Identifier\UserId;
use Datana\Doctrine\Testcase\UidTypeTestCase;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\AbstractUid;

final class UserIdTypeTest extends UidTypeTestCase
{
    /**
     * @return UserIdType
     */
    protected static function createType(): Type
    {
        return new UserIdType();
    }

    protected static function name(): string
    {
        return UserIdType::class;
    }

    /**
     * @return UserId
     */
    protected static function createId(): AbstractUid
    {
        return new UserId();
    }
}
