<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Enum\Type;
use App\Domain\Identifier\LetterId;
use App\ValueResolver\LetterIdValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class LetterIdValueResolverTest extends ValueResolverTestCase
{
    public static function createValueResolver(): ValueResolverInterface
    {
        return new LetterIdValueResolver();
    }

    public static function supportedClass(): string
    {
        return LetterId::class;
    }

    public static function unsupportedProvider(): \Generator
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['letterId' => (new LetterId())->toString()]),
            new ArgumentMetadata('foo', LetterId::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['foo' => (new LetterId())->toString()]),
            new ArgumentMetadata('foo', LetterId::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['letterId' => (new LetterId())->toString()]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];

        yield 'not-supported: invalid-ulid' => [
            new Request([], [], ['letterId' => 'unknown']),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['letterId' => (new LetterId())->toString()]),
            new ArgumentMetadata('foo', LetterId::class, false, false, false, false),
            null,
        ];
    }

}
