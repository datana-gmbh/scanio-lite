<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Enum;

use App\Domain\Enum\Category;
use OskarStark\Enum\Test\EnumTestCase;

/**
 * @covers \App\Domain\Enum\Category
 */
final class CategoryTest extends EnumTestCase
{
    /**
     * @test
     *
     * @dataProvider labelProvider
     */
    public function label(string $expected, Category $category): void
    {
        self::assertSame($expected, $category->label());
    }

    /**
     * @return \Generator<array{0: string, 1: Category}>
     */
    public static function labelProvider(): iterable
    {
        yield ['Sonstiges', Category::Other];
        yield ['Unbearbeitet', Category::Pending];
        yield ['Unbekannt', Category::Unknown];
    }

    /**
     * @test
     *
     * @dataProvider iconProvider
     */
    public function icon(string $expected, Category $category): void
    {
        self::assertSame($expected, $category->icon());
    }

    /**
     * @return \Generator<array{0: string, 1: Category}>
     */
    public static function iconProvider(): iterable
    {
        yield ['fa-light fa-clipboard-list', Category::Pending];
        yield ['fa-light fa-square-question', Category::Unknown];
    }

    /**
     * @test
     *
     * @dataProvider showCountInTreeProvider
     */
    public function showCountInTree(bool $expected, Category $belegtyp): void
    {
        self::assertSame($expected, $belegtyp->showCountInTree());
    }

    /**
     * @return \Generator<array{0: bool, 1: Category}>
     */
    public static function showCountInTreeProvider(): iterable
    {
        yield [true, Category::Pending];
    }

    protected static function getClass(): string
    {
        return Category::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 3;
    }
}
