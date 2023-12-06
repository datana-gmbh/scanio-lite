<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Domain\Value;

use App\Crud\Domain\Value\Pagination;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Crud\Domain\Value\Pagination
 */
final class PaginationTest extends UnitTestCase
{
    /**
     * @test
     */
    public function defaults(): void
    {
        $faker = self::faker();

        $pagination = new Pagination(1, $faker->numberBetween(10, 4000));

        self::assertSame(20, $pagination->limit);
    }

    /**
     * @test
     */
    public function hasNextPageReturnsFalse(): void
    {
        $pagination = new Pagination(100, 1000, 10);

        self::assertFalse($pagination->hasNextPage());
    }

    /**
     * @test
     */
    public function hasNextPageReturnsTrue(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertTrue($pagination->hasNextPage());
    }

    /**
     * @test
     */
    public function hasPreviousPageReturnsFalse(): void
    {
        $pagination = new Pagination(1, 1000, 10);

        self::assertFalse($pagination->hasPreviousPage());
    }

    /**
     * @test
     */
    public function hasPreviousPageReturnsTrue(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertTrue($pagination->hasPreviousPage());
    }

    /**
     * @test
     */
    public function previousPage(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertSame(3, $pagination->previousPage());
    }

    /**
     * @test
     */
    public function nextPage(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertSame(5, $pagination->nextPage());
    }

    /**
     * @test
     */
    public function totalPages(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertSame(100, $pagination->totalPages);
    }

    /**
     * @test
     */
    public function offset(): void
    {
        $pagination = new Pagination(4, 1000, 10);

        self::assertSame(30, $pagination->offset);
    }
}
