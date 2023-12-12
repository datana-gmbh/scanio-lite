<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Form\Choices;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Pending extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'inboxDate',
            DatePickerType::class,
            [
                'label' => 'Posteingangsdatum',
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $builder->add(
            'category',
            EnumType::class,
            [
                'class' => Category::class,
                'label' => 'Kategorie',
                'required' => true,
                'placeholder' => Choices::PLACEHOLDER,
                'choice_label' => static fn (Category $category) => $category->label(),
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );
    }

    public function supports(Group $group, Category $category): bool
    {
        return $group->equals(Group::Default)
            && $category->equals(Category::Pending);
    }
}
