<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Enum\Category;
use App\ValueResolver\CategoryValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CategoryValueResolverTest extends ValueResolverTestCase
{
    public static function supportedClass(): string
    {
        return Category::class;
    }

    /**
     * @return CategoryValueResolver
     */
    public static function createValueResolver(): ValueResolverInterface
    {
        return new CategoryValueResolver();
    }

    public static function unsupportedProvider(): iterable
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['category' => Category::Other->value]),
            new ArgumentMetadata('foo', Category::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['bar' => Category::Other->value]),
            new ArgumentMetadata('foo', Category::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['category' => Category::Other->value]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['category' => Category::Other->value]),
            new ArgumentMetadata('foo', Category::class, false, false, false, false),
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
            new Request([], [], ['category' => 'unknown-category']),
            new ArgumentMetadata('foo', Category::class, false, false, false, false),
        );
    }
}
