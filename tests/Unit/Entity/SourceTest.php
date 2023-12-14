<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Fixtures\Factory\SourceFactory;
use App\Source\Value\Type;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Entity\Source
 */
final class SourceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function stringableWithPath(): void
    {
        $storage = SourceFactory::new([
            'type' => Type::Dropbox,
            'path' => '/foo/bar',
        ])
            ->create()
            ->object();

        self::assertSame('dropbox:/foo/bar', (string) $storage);
    }
}
