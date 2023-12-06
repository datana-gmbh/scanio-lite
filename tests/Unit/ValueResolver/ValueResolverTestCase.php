<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueResolver;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

abstract class ValueResolverTestCase extends TestCase
{
    /**
     * @return \Generator<array{0: Request, 1: ArgumentMetadata}>
     */
    abstract public static function unsupportedProvider(): iterable;

    /**
     * @return \Generator<array{0: Request, 1: ArgumentMetadata, 2: null|class-string}>
     */
    abstract public static function resolveProvider(): iterable;

    /**
     * @test
     *
     * @dataProvider unsupportedProvider
     */
    final public function unsupported(Request $request, ArgumentMetadata $argument): void
    {
        $argumentResolver = static::createValueResolver();

        self::assertSame([], iterator_to_array($argumentResolver->resolve($request, $argument)));
    }

    /**
     * @test
     *
     * @dataProvider resolveProvider
     *
     * @phpstan-param class-string<\Throwable> $exceptionClass
     */
    final public function resolve(Request $request, ArgumentMetadata $argument, ?string $exceptionClass): void
    {
        $argumentResolver = static::createValueResolver();

        if (null !== $exceptionClass) {
            $this->expectException($exceptionClass);
            $argumentResolver->resolve($request, $argument);

            return;
        }

        $argumentResolverResult = iterator_to_array($argumentResolver->resolve($request, $argument));
        self::assertCount(1, $argumentResolverResult);
        self::assertContainsOnly(static::supportedClass(), $argumentResolverResult);
    }

    abstract protected static function createValueResolver(): ValueResolverInterface;

    /**
     * @return class-string
     */
    abstract protected static function supportedClass(): string;
}
