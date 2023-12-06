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
        yield ['Löschliste', Type::LOESCHLISTE];
        yield ['Sonstiges', Type::SONSTIGES];
        yield ['Unbearbeitet', Type::UNBEARBEITET];
        yield ['Unbekannt', Type::UNBEKANNT];
        yield ['Unvollständig', Type::UNVOLLSTAENDIG];
        yield ['Übertragen', Type::UEBERTRAGEN];
    }

    /**
     * @test
     *
     * @dataProvider statusProvider
     */
    public function status(string $expected, Type $belegtyp): void
    {
        self::assertSame($expected, $belegtyp->status());
    }

    /**
     * @return \Generator<array{0: string, 1: Type}>
     */
    public static function statusProvider(): iterable
    {
        yield ['ktSync', Type::KT_SYNC];
        yield ['pending', Type::UNBEARBEITET];
        yield ['sonstiges', Type::SONSTIGES];
        yield ['toBeDeleted', Type::LOESCHLISTE];
        yield ['uebertragen', Type::UEBERTRAGEN];
        yield ['unknown', Type::UNBEKANNT];
        yield ['unvollstaendig', Type::UNVOLLSTAENDIG];
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
        yield ['fa-light fa-arrow-right-to-bracket', Type::KT_SYNC];
        yield ['fa-light fa-trash', Type::LOESCHLISTE];
        yield ['fa-light fa-square-check', Type::UEBERTRAGEN];
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
        yield [false, Type::LOESCHLISTE];
        yield [false, Type::UEBERTRAGEN];
    }

    protected static function getClass(): string
    {
        return Type::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 96;
    }
}
