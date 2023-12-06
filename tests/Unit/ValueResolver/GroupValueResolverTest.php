<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use App\Domain\Enum\Group;
use App\ValueResolver\GroupValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GroupValueResolverTest extends ValueResolverTestCase
{
    public static function supportedClass(): string
    {
        return Group::class;
    }

    /**
     * @return GroupValueResolver
     */
    public static function createValueResolver(): ValueResolverInterface
    {
        return new GroupValueResolver();
    }

    public static function unsupportedProvider(): iterable
    {
        yield 'not-supported: variadic' => [
            new Request([], [], ['group' => Group::Default->value]),
            new ArgumentMetadata('foo', Group::class, true, false, false, false),
        ];

        yield 'not-supported: wrong-route-placeholder' => [
            new Request([], [], ['bar' => Group::Default->value]),
            new ArgumentMetadata('foo', Group::class, false, false, false, false),
        ];

        yield 'not-supported: wrong-typehint' => [
            new Request([], [], ['group' => Group::Default->value]),
            new ArgumentMetadata('foo', \stdClass::class, false, false, false, false),
        ];
    }

    public static function resolveProvider(): \Generator
    {
        yield 'supported' => [
            new Request([], [], ['group' => Group::Default->value]),
            new ArgumentMetadata('foo', Group::class, false, false, false, false),
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
            new Request([], [], ['group' => 'unknown-group']),
            new ArgumentMetadata('foo', Group::class, false, false, false, false),
        );
    }
}
