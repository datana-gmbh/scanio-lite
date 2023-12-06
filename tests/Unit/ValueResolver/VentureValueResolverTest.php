<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Enum\Venture;
use App\ValueResolver\VentureValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class VentureValueResolverTest extends ValueResolverTestCase
{
    public static function supportedClass(): string
    {
        return Venture::class;
    }

    /**
     * @return VentureValueResolver
     */
    public static function createValueResolver(): ValueResolverInterface
    {
        return new VentureValueResolver();
    }

    public static function unsupportedProvider(): iterable
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['venture' => Venture::Default->value]),
            new ArgumentMetadata('foo', Venture::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['bar' => Venture::Default->value]),
            new ArgumentMetadata('foo', Venture::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['venture' => Venture::Default->value]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['venture' => Venture::Default->value]),
            new ArgumentMetadata('foo', Venture::class, false, false, false, false),
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
            new Request([], [], ['venture' => 'unknown-venture']),
            new ArgumentMetadata('foo', Venture::class, false, false, false, false),
        );
    }
}
