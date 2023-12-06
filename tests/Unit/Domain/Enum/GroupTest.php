<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\Group;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Domain\Enum\Group
 */
final class GroupTest extends EnumTestCase
{
    /**
     * @test
     *
     * @dataProvider labelProvider
     */
    public function label(string $expected, Group $group): void
    {
        self::assertSame($expected, $group->label());
    }

    /**
     * @return \Generator<array<Group|string>>
     */
    public static function labelProvider(): iterable
    {
        yield ['Standard', Group::Default];
    }

    protected static function getClass(): string
    {
        return Group::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 1;
    }
}
