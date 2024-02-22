<?php

declare(strict_types=1);

namespace App\Tests\Unit\Bridge\Azure\Domain\Value;

use App\Bridge\Azure\Domain\Value\AzureDsn;
use App\Tests\Unit\UnitTestCase;

final class AzureDsnTest extends UnitTestCase
{
    /**
     * @test
     *
     * @dataProvider validDnsProvider
     */
    public function valid(
        string $dsn,
        string $raw,
        string $defaultEndpointsProtocol,
        string $accountName,
        string $accountKey,
        string $endpointSuffix,
        string $containerName,
    ): void {
        $azureDsn = new AzureDsn($dsn);

        self::assertSame($raw, $azureDsn->raw);
        self::assertSame($defaultEndpointsProtocol, $azureDsn->defaultEndpointsProtocol);
        self::assertSame($accountName, $azureDsn->accountName);
        self::assertSame($accountKey, $azureDsn->accountKey);
        self::assertSame($endpointSuffix, $azureDsn->endpointSuffix);
        self::assertSame($containerName, $azureDsn->containerName);
    }

    /**
     * @return \Generator<string, string[]>
     */
    public static function validDnsProvider(): iterable
    {
        $faker = self::faker();

        $dsn = sprintf(
            'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s;ContainerName=%s',
            $defaultEndpointsProtocol = $faker->randomElement(['http', 'https']),
            $accountName = $faker->userName(),
            $accountKey = $faker->md5(),
            $endpointSuffix = $faker->domainName(),
            $containerName = $faker->word(),
        );

        $expectedDsn = sprintf(
            'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s',
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
        );

        yield 'ContainerName at the end' => [
            $dsn,
            $expectedDsn,
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
            $containerName,
        ];

        $dsn = sprintf(
            'DefaultEndpointsProtocol=%s;ContainerName=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s',
            $defaultEndpointsProtocol = $faker->randomElement(['http', 'https']),
            $containerName = $faker->word(),
            $accountName = $faker->userName(),
            $accountKey = $faker->md5(),
            $endpointSuffix = $faker->domainName(),
        );

        $expectedDsn = sprintf(
            'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s',
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
        );

        yield 'ContainerName in the middle' => [
            $dsn,
            $expectedDsn,
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
            $containerName,
        ];

        $dsn = sprintf(
            'ContainerName=%s;DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s',
            $containerName = $faker->word(),
            $defaultEndpointsProtocol = $faker->randomElement(['http', 'https']),
            $accountName = $faker->userName(),
            $accountKey = $faker->md5(),
            $endpointSuffix = $faker->domainName(),
        );

        $expectedDsn = sprintf(
            'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s;EndpointSuffix=%s',
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
        );

        yield 'ContainerName at the beginning' => [
            $dsn,
            $expectedDsn,
            $defaultEndpointsProtocol,
            $accountName,
            $accountKey,
            $endpointSuffix,
            $containerName,
        ];
    }

    /**
     * @test
     *
     * @dataProvider invalidDnsProvider
     */
    public function invalid(string $dsn): void
    {
        self::expectException(\InvalidArgumentException::class);
        new AzureDsn($dsn);
    }

    /**
     * @return \Generator<string, string[]>
     */
    public static function invalidDnsProvider(): iterable
    {
        yield 'ContainerName is empty' => ['ContainerName=;DefaultEndpointsProtocol=https;AccountName=testaccount;AccountKey=23i9jnccccdfjd;EndpointSuffix=foo.com'];
        yield 'DefaultEndpointsProtocol is empty' => ['ContainerName=fooo;DefaultEndpointsProtocol=;AccountName=;AccountKey=23i9jnccccdfjd;EndpointSuffix=foo.com'];
        yield 'DefaultEndpointsProtocol Does not contain http' => ['ContainerName=fooo;DefaultEndpointsProtocol=sftp;AccountName=test;AccountKey=23i9jnccccdfjd;EndpointSuffix=foo.com'];
        yield 'AccountName is empty' => ['ContainerName=fooo;DefaultEndpointsProtocol=https;AccountName=;AccountKey=23i9jnccccdfjd;EndpointSuffix=foo.com'];
        yield 'AccountKey is empty' => ['ContainerName=fooo;DefaultEndpointsProtocol=https;AccountName=test;AccountKey=;EndpointSuffix=foo.com'];
        yield 'EndpointSuffix is empty' => ['ContainerName=fooo;DefaultEndpointsProtocol=https;AccountName=test;AccountKey=;EndpointSuffix='];
        yield 'Empty Dsn' => [''];
        yield 'Whitespace only Dsn' => [' '];
    }
}
