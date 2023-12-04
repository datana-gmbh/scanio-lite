<?php

declare(strict_types=1);

namespace App\Tests\Integration\ValueResolver;

use App\Tests\Integration\IntegrationTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

abstract class ValueResolverTestCase extends IntegrationTestCase
{
    /**
     * @return iterable<array{0: Request, 1: ArgumentMetadata}>
     */
    abstract public static function unsupportedProvider(): iterable;

    /**
     * @test
     *
     * @dataProvider unsupportedProvider
     */
    final public function unsupported(Request $request, ArgumentMetadata $argument): void
    {
        $argumentResolver = static::createValueResolver();

        self::assertSame([], $argumentResolver->resolve($request, $argument));
    }

    abstract protected static function createValueResolver(): ValueResolverInterface;
}
