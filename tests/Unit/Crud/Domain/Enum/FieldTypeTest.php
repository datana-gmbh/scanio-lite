<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Domain\Enum;

use App\Crud\Domain\Enum\FieldType;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Crud\Domain\Enum\FieldType
 */
final class FieldTypeTest extends EnumTestCase
{
    protected static function getClass(): string
    {
        return FieldType::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 7;
    }
}
