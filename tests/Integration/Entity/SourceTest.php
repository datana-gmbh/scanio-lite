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
            'Dieser Wert sollte nicht leer sein.',
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
            'Dieser Wert sollte nicht leer sein.',
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
            'Dieser Wert sollte nicht leer sein.',
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

    /**
     * @test
     */
    public function isInvalidAzureTokenIsMissing(): void
    {
        $source = SourceFactory::new()
            ->azure()
            ->withAttributes(['token' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('token', $violations, [
            'Dieser Wert sollte nicht leer sein.',
        ]);
    }

    /**
     * @test
     */
    public function isInvalidAzureTokenMissingContainerName(): void
    {
        $source = SourceFactory::new()
            ->azure()
            ->withAttributes(['token' => 'DefaultEndpointsProtocol=https;AccountName=sdhjfdbd;AccountKey=21wed;EndpointSuffix=core.windows.net'])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('token', $violations, [
            'Dieser Wert muss einen Key "ContainerName" beinhalten',
        ]);
    }

    /**
     * @test
     */
    public function isValidAzureToken(): void
    {
        $source = SourceFactory::new()
            ->azure()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertNoViolationsForPropertyPath('token', $violations);
    }

    /**
     * @test
     */
    public function isInvalidAzurePathIsMissing(): void
    {
        $source = SourceFactory::new()
            ->azure()
            ->withAttributes(['path' => null])
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertViolationsForPropertyPath('path', $violations, [
            'Dieser Wert sollte nicht leer sein.',
        ]);
    }

    /**
     * @test
     */
    public function isValidAzurePath(): void
    {
        $source = SourceFactory::new()
            ->azure()
            ->withoutPersisting()
            ->create()
            ->object();

        $violations = self::validator()->validate($source);

        self::assertNoViolationsForPropertyPath('path', $violations);
    }
}
