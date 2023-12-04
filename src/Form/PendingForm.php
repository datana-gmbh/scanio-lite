<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

final class PendingForm extends AbstractType
{
    public function getParent(): string
    {
        return BaseForm::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'venture',
            ChoiceType::class,
            [
                'label' => 'Venture',
                'mapped' => false,
                'choices' => $options['transitions'],
                'placeholder' => Choices::PLACEHOLDER,
            ],
        );

        $builder->add('submit', SubmitType::class, ['label' => 'Speichern']);
    }
}
