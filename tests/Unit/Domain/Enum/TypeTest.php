<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\Type;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Domain\Enum\Type
 */
final class TypeTest extends EnumTestCase
{
    /**
     * @test
     *
     * @dataProvider labelProvider
     */
    public function label(string $expected, Type $belegtyp): void
    {
        self::assertSame($expected, $belegtyp->label());
    }

    /**
     * @return \Generator<array{0: string, 1: Type}>
     */
    public static function labelProvider(): iterable
    {
        yield ['Sonstiges', Type::SONSTIGES];
        yield ['Unbearbeitet', Type::UNBEARBEITET];
        yield ['Unbekannt', Type::UNBEKANNT];
        yield ['Unvollständig', Type::UNVOLLSTAENDIG];
    }



    /**
     * @test
     *
     * @dataProvider iconProvider
     */
    public function icon(string $expected, Type $belegtyp): void
    {
        self::assertSame($expected, $belegtyp->icon());
    }

    /**
     * @return \Generator<array{0: string, 1: Type}>
     */
    public static function iconProvider(): iterable
    {
        yield ['fa-light fa-clipboard-list', Type::UNBEARBEITET];
        yield ['fa-light fa-square-question', Type::UNBEKANNT];
        yield ['fa-light fa-square-exclamation', Type::UNVOLLSTAENDIG];
    }

    /**
     * @test
     *
     * @dataProvider showCountInTreeProvider
     */
    public function showCountInTree(bool $expected, Type $belegtyp): void
    {
        self::assertSame($expected, $belegtyp->showCountInTree());
    }

    /**
     * @return \Generator<array{0: bool, 1: Type}>
     */
    public static function showCountInTreeProvider(): iterable
    {
        yield [true, Type::UNBEARBEITET];
    }

    protected static function getClass(): string
    {
        return Type::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 5;
    }
}
