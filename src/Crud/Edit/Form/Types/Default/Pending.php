<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Form\Choices;
use App\Form\Type\DatePickerType;
use App\Form\Type\SearchableChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Pending extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function getParent(): string
    {
        return BaseForm::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'posteingangsdatum',
            DatePickerType::class,
            [
                'label' => 'Posteingangsdatum',
                'property_path' => 'data[posteingangsdatum]',
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $builder->add(
            'type',
            SearchableChoicesType::class,
            [
                'label' => 'Typ',
                'required' => true,
                'choices' => Choices::types(),
                'placeholder' => Choices::PLACEHOLDER,
                'property_path' => 'data[type]',
                'attr' => ['class' => 'js-advanced-select-custom'],
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );
    }

    public function supports(Venture $venture, Type $type): bool
    {
        return $venture->equals(Venture::Default)
            && $type->equals(Type::Pending);
    }
}
