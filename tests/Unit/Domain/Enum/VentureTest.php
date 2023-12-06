<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\Venture;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Domain\Enum\Venture
 */
final class VentureTest extends EnumTestCase
{
    /**
     * @test
     *
     * @dataProvider labelProvider
     */
    public function label(string $expected, Venture $venture): void
    {
        self::assertSame($expected, $venture->label());
    }

    /**
     * @return \Generator<array<string|Venture>>
     */
    public static function labelProvider(): iterable
    {
        yield ['Standard', Venture::Default];
    }

    protected static function getClass(): string
    {
        return Venture::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 1;
    }
}
