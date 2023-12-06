<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\Extension;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Domain\Enum\Extension
 */
final class ExtensionTest extends EnumTestCase
{
    protected static function getClass(): string
    {
        return Extension::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 7;
    }
}
