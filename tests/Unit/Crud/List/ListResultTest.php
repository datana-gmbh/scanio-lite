<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\List;

use App\Crud\Domain\Enum\FieldType;
use App\Crud\Domain\Value\Field;
use App\Crud\List\ListResult;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Crud\List\ListResult
 */
final class ListResultTest extends UnitTestCase
{
    /**
     * @test
     */
    public function instantiate(): void
    {
        $result = new ListResult($fields = [new Field(FieldType::ID, 'ID', 'id')], []);

        self::assertSame($fields, $result->fields);
        self::assertEmpty($result->rows);
        self::assertFalse($result->hasRows());
    }

    /**
     * @test
     */
    public function instantiateInvalid(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new ListResult([], []);
    }

    /**
     * @test
     */
    public function hasRows(): void
    {
        $result = new ListResult([new Field(FieldType::ID, 'ID', 'id')], [
            [],
            [],
        ]);
        self::assertTrue($result->hasRows());
    }
}
