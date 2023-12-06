<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Enum\Type;
use App\Domain\Identifier\LetterId;
use App\ValueResolver\TypeValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class TypeValueResolverTest extends ValueResolverTestCase
{
    public static function supportedClass(): string
    {
        return Type::class;
    }

    /**
     * @return TypeValueResolver
     */
    public static function createValueResolver(): ValueResolverInterface
    {
        return new TypeValueResolver();
    }

    public static function unsupportedProvider(): iterable
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['type' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['bar' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['type' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['type' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
            null,
        ];
    }

    /**
     * @test
     */
    public function resolveThrowsNotFoundHttpException(): void
    {
        $valueResolver = self::createValueResolver();

        self::expectException(NotFoundHttpException::class);

        $valueResolver->resolve(
            new Request([], [], ['type' => 'unknown-belegtyp']),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
        );
    }
}
