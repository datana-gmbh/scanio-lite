<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final readonly class FormTypeFactory implements FormTypeFactoryInterface
{
    /**
     * @var FormTypeFactoryLoadableInterface[]
     */
    private array $formTypes;

    /**
     * @param iterable<FormTypeFactoryLoadableInterface> $formTypes
     */
    public function __construct(
        #[TaggedIterator(tag: FormTypeFactoryLoadableInterface::class)]
        iterable $formTypes,
    ) {
        $this->formTypes = $formTypes instanceof \Traversable ? iterator_to_array($formTypes) : $formTypes;
    }

    public function create(Group $group, Category $category): FormTypeFactoryLoadableInterface
    {
        $found = array_filter(
            $this->formTypes,
            static fn (FormTypeFactoryLoadableInterface $formType) => $formType->supports($group, $category),
        );

        $count = \count($found);

        if (1 === $count) {
            return reset($found);
        }

        if (1 < $count) {
            throw new \InvalidArgumentException(sprintf(
                'Multiple form types found for group "%s" and category "%s".',
                $group->value,
                $category->value,
            ));
        }

        throw new \InvalidArgumentException(sprintf(
            'No form type found for group "%s" and category "%s".',
            $group->value,
            $category->value,
        ));
    }
}
