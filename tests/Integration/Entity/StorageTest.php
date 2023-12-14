<?php

declare(strict_types=1);

namespace App\Tests\Integration\Entity;

use App\Fixtures\Factory\StorageFactory;
use App\Tests\Integration\IntegrationTestCase;

final class StorageTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function isInvalidDropboxTokenIsMissing(): void
    {
        $storage = StorageFactory::new()
            ->dropbox()
            ->withAttributes(['token' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertViolationsForPropertyPath('token', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidDropboxToken(): void
    {
        $storage = StorageFactory::new()
            ->dropbox()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertNoViolationsForPropertyPath('token', $violations);
    }

    /**
     * @test
     */
    public function isInvalidDropboxPathIsMissing(): void
    {
        $storage = StorageFactory::new()
            ->dropbox()
            ->withAttributes(['path' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertViolationsForPropertyPath('path', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidDropboxPath(): void
    {
        $storage = StorageFactory::new()
            ->dropbox()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }

    /**
     * @test
     */
    public function isInvalidLocalPathIsMissing(): void
    {
        $storage = StorageFactory::new()
            ->local()
            ->withAttributes(['path' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertViolationsForPropertyPath('path', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidLocalPath(): void
    {
        $storage = StorageFactory::new()
            ->local()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }
}
