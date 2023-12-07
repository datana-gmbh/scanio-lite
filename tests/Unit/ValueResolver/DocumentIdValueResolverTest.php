<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Identifier\DocumentId;
use App\ValueResolver\DocumentIdValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class DocumentIdValueResolverTest extends ValueResolverTestCase
{
    public static function createValueResolver(): ValueResolverInterface
    {
        return new DocumentIdValueResolver();
    }

    public static function supportedClass(): string
    {
        return DocumentId::class;
    }

    public static function unsupportedProvider(): \Generator
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['documentId' => (new DocumentId())->toString()]),
            new ArgumentMetadata('foo', DocumentId::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['foo' => (new DocumentId())->toString()]),
            new ArgumentMetadata('foo', DocumentId::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['documentId' => (new DocumentId())->toString()]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];

        yield 'not-supported: invalid-ulid' => [
            new Request([], [], ['documentId' => 'unknown']),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['documentId' => (new DocumentId())->toString()]),
            new ArgumentMetadata('foo', DocumentId::class, false, false, false, false),
            null,
        ];
    }
}
