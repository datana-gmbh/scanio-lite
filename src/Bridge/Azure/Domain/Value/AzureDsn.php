<?php

declare(strict_types=1);

namespace App\Bridge\Azure\Domain\Value;

use OskarStark\Value\TrimmedNonEmptyString;
use Symfony\Component\String\UnicodeString;
use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;

final readonly class AzureDsn
{
    public string $raw;
    public string $containerName;
    public string $accountName;
    public string $accountKey;
    public string $defaultEndpointsProtocol;
    public string $endpointSuffix;

    public function __construct(string $dsn)
    {
        $dsn = TrimmedNonEmptyString::fromString($dsn)->toString();

        $containerName = '';
        $accountName = '';
        $accountKey = '';
        $defaultEndpointsProtocol = '';
        $endpointSuffix = '';

        foreach (u($dsn)->split(';') as $parts) {
            [$key, $value] = $parts->split('=', 2);

            Assert::isInstanceOf($value, UnicodeString::class);
            Assert::isInstanceOf($key, UnicodeString::class);

            if ($key->equalsTo('ContainerName')) {
                $containerName = TrimmedNonEmptyString::fromString($value->toString())->toString();
            }

            if ($key->equalsTo('AccountName')) {
                $accountName = TrimmedNonEmptyString::fromString($value->toString())->toString();
            }

            if ($key->equalsTo('AccountKey')) {
                $accountKey = TrimmedNonEmptyString::fromString($value->toString())->toString();
            }

            if ($key->equalsTo('DefaultEndpointsProtocol')) {
                Assert::true($value->startsWith('http'));
                $defaultEndpointsProtocol = TrimmedNonEmptyString::fromString($value->toString())->toString();
            }

            if ($key->equalsTo('EndpointSuffix')) {
                $endpointSuffix = TrimmedNonEmptyString::fromString($value->toString())->toString();
            }
        }

        $this->containerName = $containerName;
        $this->accountName = $accountName;
        $this->accountKey = $accountKey;
        $this->defaultEndpointsProtocol = $defaultEndpointsProtocol;
        $this->endpointSuffix = $endpointSuffix;

        $this->raw = u($dsn)
            ->replaceMatches('/ContainerName\=[^;]+;?/', '')
            ->trimStart(';')
            ->trimEnd(';')
            ->trim()
            ->toString();
    }
}
