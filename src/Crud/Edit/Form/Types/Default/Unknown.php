<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class Unknown extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Document $document */
        $document = $options['data'];

        $builder->add(
            'important',
            CheckboxType::class,
            [
                'label' => 'Wichtiges Dokument?',
                'property_path' => 'data[important]',
            ],
        );
    }

    public function supports(Group $group, Category $category): bool
    {
        return $group->equals(Group::Default)
            && $category->equals(Category::Unknown);
    }
}
