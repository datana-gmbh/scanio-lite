<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Domain\Enum;

use App\Crud\Domain\Enum\SortDirection;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Crud\Domain\Enum\SortDirection
 */
final class SortDirectionTest extends EnumTestCase
{
    protected static function getClass(): string
    {
        return SortDirection::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 2;
    }
}
