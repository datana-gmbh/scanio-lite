<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use App\Condition\ConditionProviderInterface;
use App\Crud\Edit\Form\FormTypeFactoryLoadableInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use App\ExpressionLanguage\FieldExpressionLanguage;
use App\Form\Choices;
use App\Form\Type\DatePickerType;
use App\Form\Type\SearchableChoicesType;
use App\Repository\FieldRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Pending extends AbstractType implements FormTypeFactoryLoadableInterface
{
    public function __construct(
        private readonly ConditionProviderInterface $conditionProvider,
        private readonly FieldExpressionLanguage $expressionLanguage,
    ) {
    }

    public function getParent(): string
    {
        return BaseForm::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Document $document */
        $document = $options['data'];

        if ($this->expressionLanguage->evaluateDocument($document, $this->conditionProvider->getCondition('posteingangsdatum'))) {
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
        }

        if ($this->expressionLanguage->evaluateDocument($document, $this->conditionProvider->getCondition('category'))) {
            $builder->add(
                'category',
                SearchableChoicesType::class,
                [
                    'label' => 'Typ',
                    'required' => true,
                    'choices' => Choices::categories(),
                    'placeholder' => Choices::PLACEHOLDER,
                    'property_path' => 'data[category]',
                    'attr' => ['class' => 'js-advanced-select-custom'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ],
            );
        }
    }

    public function supports(Group $group, Category $category): bool
    {
        return $group->equals(Group::Default)
            && $category->equals(Category::Pending);
    }
}
