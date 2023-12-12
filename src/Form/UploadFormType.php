<?php

declare(strict_types=1);

namespace App\Form;

use Safe\DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

final class UploadFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Datei',
                'constraints' => [
                    new File(
                        mimeTypes: ['application/pdf'],
                        mimeTypesMessage: 'Der Dateityp der hochgeladenen Datei ist nicht unterstützt ({{ type }}). Erlaubte Typen sind {{ types }}',
                    ),
                ],
                'help' => 'Folgende Formate werden unterstützt: .pdf',
            ])
            ->add('inbox_date', DateType::class, [
                'label' => 'Posteingangsdatum',
                'required' => true,
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                    new Range(max: new DateTimeImmutable()),
                ],
            ])
            ->add('group', ChoiceType::class, [
                'label' => 'Gruppe',
                'choices' => Choices::groups(),
                'required' => true,
                'placeholder' => Choices::PLACEHOLDER,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Hochladen',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }
}
