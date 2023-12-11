<?php

declare(strict_types=1);

namespace App\Tests\Unit\Routing;

use App\Routing\Routes;
use App\Tests\Unit\UnitTestCase;
use ReflectionClass;

final class RoutesTest extends UnitTestCase
{
    /**
     * @test
     */
    public function numberOfRoutes(): void
    {
        $class = new ReflectionClass(Routes::class);

        self::assertCount(6, $class->getConstants());
    }
}
