<?php

declare(strict_types=1);

namespace App\Tests\Unit\Crud\Edit\Form;

use App\Crud\Edit\Form\FormTypeFactory;
use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Group;
use App\Domain\Enum\Type;
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
                public function supports(Group $group, Type $type): bool
                {
                    return true;
                }
            },
        ]);

        $factory->create(Group::Default, Type::Other);
    }

    /**
     * @test
     */
    public function throwsExceptionIfNoFormTypeIsFound(): void
    {
        $factory = new FormTypeFactory([]);

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('No form type found for group "default" and type "other".');

        $factory->create(Group::Default, Type::Other);
    }

    /**
     * @test
     */
    public function throwsExceptionIfMultipleFormTypesAreFound(): void
    {
        $factory = new FormTypeFactory([
            new class() extends AbstractType implements FormTypeFactoryLoadableInterface {
                public function supports(Group $group, Type $type): bool
                {
                    return true;
                }
            },
            new class() extends AbstractType implements FormTypeFactoryLoadableInterface {
                public function supports(Group $group, Type $type): bool
                {
                    return true;
                }
            },
        ]);

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Multiple form types found for group "default" and type "other".');

        $factory->create(Group::Default, Type::Other);
    }
}
