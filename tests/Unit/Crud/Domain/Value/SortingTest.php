<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Domain\Value;

use App\Crud\Domain\Enum\SortDirection;
use App\Crud\Domain\Value\Sorting;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Crud\Domain\Value\Sorting
 */
final class SortingTest extends UnitTestCase
{
    /**
     * @test
     */
    public function defaults(): void
    {
        $faker = self::faker();

        $pagination = new Sorting($property = $faker->word(), $direction = $faker->randomElement(SortDirection::cases()));

        self::assertSame($property, $pagination->property);
        self::assertTrue($pagination->direction->equals($direction));
    }
}
