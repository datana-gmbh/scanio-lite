<?php

declare(strict_types=1);

namespace App\ExpressionLanguage\ExpressionFunctionProviders;

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
                static function ($group) {
                    return '\App\Domain\Enum\Group::from('.$group.') === $document->getGroup()';
                },
                static function ($arguments, $group) {
                    /** @var Document $document */
                    $document = $arguments['document'];

                    try {
                        return $document->getGroup()->equals(\App\Domain\Enum\Group::from($group));
                    } catch (\ValueError) {
                        return false;
                    }
                },
            ),
            new ExpressionFunction(
                'isCategory',
                static function ($category) {
                    return '\App\Domain\Enum\Category::from('.$category.') === $document->getCategory()';
                },
                static function ($arguments, $category) {
                    /** @var Document $document */
                    $document = $arguments['document'];

                    try {
                        return $document->getCategory()->equals(\App\Domain\Enum\Category::from($category));
                    } catch (\ValueError) {
                        return false;
                    }
                },
            ),
        ];
    }
}
