<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Domain\Enum\StorageType;
use App\Fixtures\Factory\StorageFactory;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Entity\Storage
 */
final class StorageTest extends UnitTestCase
{
    /**
     * @test
     */
    public function stringableWithPath(): void
    {
        $storage = StorageFactory::new([
            'storageType' => StorageType::Dropbox,
            'path' => '/foo/bar',
        ])
            ->create()
            ->object();

        self::assertSame('dropbox:/foo/bar', (string) $storage);
    }
}
