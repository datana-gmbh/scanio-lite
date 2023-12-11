<?php

declare(strict_types=1);

namespace App\ExpressionLanguage;

use App\Entity\Document;
use App\ExpressionLanguage\ExpressionFunctionProviders\StringExpressionLanguageProvider;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class FieldExpressionLanguage extends ExpressionLanguage
{
    public function __construct(?CacheItemPoolInterface $cache = null, array $providers = [])
    {
        // prepends the default provider to let users override it
        array_unshift(
            $providers,
            new StringExpressionLanguageProvider(),
        );

        parent::__construct($cache, $providers);
    }

    public function evaluateDocument(Document $document, Expression|string $expression): bool
    {
        return parent::evaluate($expression, [
            'document' => $document,
        ]);
    }

    public function getFunctions(): array
    {
        return $this->functions;
    }
}
