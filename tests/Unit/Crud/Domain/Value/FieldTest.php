<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Domain\Value;

use App\Crud\Domain\Enum\FieldType;
use App\Crud\Domain\Value\Field;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Crud\Domain\Value\Field
 */
final class FieldTest extends UnitTestCase
{
    /**
     * @test
     */
    public function instance(): void
    {
        $faker = self::faker();
        $field = new Field(
            $type = FieldType::ID,
            $label = $faker->word(),
            $propertyPath = $faker->word(),
        );

        self::assertTrue(FieldType::ID->equals($type));
        self::assertSame($label, $field->label);
        self::assertSame($propertyPath, $field->propertyPath);
    }
}
