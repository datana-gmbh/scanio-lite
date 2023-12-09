<?php

declare(strict_types=1);

namespace App\ExpressionLanguage\ExpressionFunctionProviders;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

final class StringExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            ExpressionFunction::fromPhp('substr'),
        ];
    }
}
