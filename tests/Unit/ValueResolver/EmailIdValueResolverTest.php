<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Identifier\EmailId;
use App\ValueResolver\EmailIdValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class EmailIdValueResolverTest extends ValueResolverTestCase
{
    public static function createValueResolver(): ValueResolverInterface
    {
        return new EmailIdValueResolver();
    }

    public static function supportedClass(): string
    {
        return EmailId::class;
    }

    public static function unsupportedProvider(): \Generator
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['emailId' => (new EmailId())->toString()]),
            new ArgumentMetadata('foo', EmailId::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['foo' => (new EmailId())->toString()]),
            new ArgumentMetadata('foo', EmailId::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['emailId' => (new EmailId())->toString()]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];

        yield 'not-supported: invalid-ulid' => [
            new Request([], [], ['emailId' => 'unknown']),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['emailId' => (new EmailId())->toString()]),
            new ArgumentMetadata('foo', EmailId::class, false, false, false, false),
            null,
        ];
    }
}
