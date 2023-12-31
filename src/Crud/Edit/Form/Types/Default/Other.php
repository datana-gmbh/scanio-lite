<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Other extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Document $document */
        $document = $options['data'];

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

    public function supports(Group $group, Category $category): bool
    {
        return $group->equals(Group::Default)
            && $category->equals(Category::Other);
    }
}
