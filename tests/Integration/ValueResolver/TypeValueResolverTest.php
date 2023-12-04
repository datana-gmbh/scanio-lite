<?php

declare(strict_types=1);

namespace App\Tests\Integration\ValueResolver;

use App\Domain\Enum\Type;
use App\ValueResolver\TypeValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class TypeValueResolverTest extends ValueResolverTestCase
{
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
            new Request([], [], ['belegtyp' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['bar' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['belegtyp' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    /**
     * @test
     */
    public function resolve(): void
    {
        $valueResolver = self::createValueResolver();
        $resolvedValue = $valueResolver->resolve(
            new Request([], [], ['belegtyp' => Type::SONSTIGES->value]),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
        );

        self::assertEquals([Type::SONSTIGES], $resolvedValue);
    }

    /**
     * @test
     */
    public function resolveThrowsNotFoundHttpException(): void
    {
        $valueResolver = self::createValueResolver();

        self::expectException(NotFoundHttpException::class);

        $valueResolver->resolve(
            new Request([], [], ['belegtyp' => 'unknown-belegtyp']),
            new ArgumentMetadata('foo', Type::class, false, false, false, false),
        );
    }
}
