<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Entity\Letter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Sonstiges extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function getParent(): string
    {
        return BaseForm::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Letter $letter */
        $letter = $options['data'];

        $builder->add(
            'name_der_datei',
            TextType::class,
            [
                'label' => 'Name der PDF',
                'required' => true,
                'property_path' => 'data[name_der_datei]',
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );
    }

    public function supports(Venture $venture, Type $type): bool
    {
        return $venture->equals(Venture::Default)
            && $type->equals(Type::Other);
    }
}
