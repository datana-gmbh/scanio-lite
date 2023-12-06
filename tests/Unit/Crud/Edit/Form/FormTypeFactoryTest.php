<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Edit\Form;

use App\Crud\Edit\Form\FormTypeFactory;
use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Tests\Unit\UnitTestCase;
use Symfony\Component\Form\AbstractType;

/**
 * @covers \App\Crud\Edit\Form\FormTypeFactory
 */
final class FormTypeFactoryTest extends UnitTestCase
{
    /**
     * @test
     *
     * @doesNotPerformAssertions
     */
    public function returnsFormType(): void
    {
        $factory = new FormTypeFactory([
            new class() extends AbstractType implements FormTypeFactoryLoadableInterface {
                public function supports(Group $group, Category $category): bool
                {
                    return true;
                }
            },
        ]);

        $factory->create(Group::Default, Category::Other);
    }

    /**
     * @test
     */
    public function throwsExceptionIfNoFormTypeIsFound(): void
    {
        $factory = new FormTypeFactory([]);

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('No form type found for group "default" and type "other".');

        $factory->create(Group::Default, Category::Other);
    }

    /**
     * @test
     */
    public function throwsExceptionIfMultipleFormTypesAreFound(): void
    {
        $factory = new FormTypeFactory([
            new class() extends AbstractType implements FormTypeFactoryLoadableInterface {
                public function supports(Group $group, Category $category): bool
                {
                    return true;
                }
            },
            new class() extends AbstractType implements FormTypeFactoryLoadableInterface {
                public function supports(Group $group, Category $category): bool
                {
                    return true;
                }
            },
        ]);

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Multiple form types found for group "default" and type "other".');

        $factory->create(Group::Default, Category::Other);
    }
}
