<?php

declare(strict_types=1);

namespace App\Tests\Integration\Entity;

use App\Fixtures\Factory\SourceFactory;
use App\Tests\Integration\IntegrationTestCase;

final class SourceTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function isInvalidDropboxTokenIsMissing(): void
    {
        $storage = SourceFactory::new()
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
        $storage = SourceFactory::new()
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
        $storage = SourceFactory::new()
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
        $storage = SourceFactory::new()
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
        $storage = SourceFactory::new()
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
        $storage = SourceFactory::new()
            ->local()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($storage);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }
}
