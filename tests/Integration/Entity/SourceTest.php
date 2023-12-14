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
        $source = SourceFactory::new()
            ->dropbox()
            ->withAttributes(['token' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('token', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidDropboxToken(): void
    {
        $source = SourceFactory::new()
            ->dropbox()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertNoViolationsForPropertyPath('token', $violations);
    }

    /**
     * @test
     */
    public function isInvalidDropboxPathIsMissing(): void
    {
        $source = SourceFactory::new()
            ->dropbox()
            ->withAttributes(['path' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('path', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidDropboxPath(): void
    {
        $source = SourceFactory::new()
            ->dropbox()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }

    /**
     * @test
     */
    public function isInvalidLocalPathIsMissing(): void
    {
        $source = SourceFactory::new()
            ->local()
            ->withAttributes(['path' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('path', $violations, [
            'This value should not be blank.',
        ]);
    }

    /**
     * @test
     */
    public function isValidLocalPath(): void
    {
        $source = SourceFactory::new()
            ->local()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }
}
