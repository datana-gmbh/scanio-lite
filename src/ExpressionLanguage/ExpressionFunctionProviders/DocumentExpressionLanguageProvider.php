<?php

declare(strict_types=1);

namespace App\ExpressionLanguage\ExpressionFunctionProviders;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class DocumentExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            new ExpressionFunction(
                'isGroup',
                static fn ($group) => '\App\Domain\Enum\Group::from('.$group.') === $document->getGroup()',
                static function ($arguments, $group) {
                    /** @var Document $document */
                    $document = $arguments['document'];

                    try {
                        return $document->getGroup()->equals(Group::from($group));
                    } catch (\ValueError) {
                        return false;
                    }
                },
            ),
            new ExpressionFunction(
                'isCategory',
                static fn ($category) => '\App\Domain\Enum\Category::from('.$category.') === $document->getCategory()',
                static function ($arguments, $category) {
                    /** @var Document $document */
                    $document = $arguments['document'];

                    try {
                        return $document->getCategory()->equals(Category::from($category));
                    } catch (\ValueError) {
                        return false;
                    }
                },
            ),
        ];
    }
}
