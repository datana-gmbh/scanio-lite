<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Domain\Identifier\DocumentId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class LetterIdValueResolver implements ValueResolverInterface
{
    private const ROUTE_PLACEHOLDER = 'letterId';

    /**
     * @return iterable<DocumentId>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->isVariadic() || DocumentId::class !== $argument->getType()) {
            return [];
        }

        $value = $request->attributes->get(self::ROUTE_PLACEHOLDER);

        if (!\is_string($value)) {
            return [];
        }

        try {
            return [DocumentId::fromString($value)];
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
