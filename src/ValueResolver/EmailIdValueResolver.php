<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Domain\Identifier\EmailId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class EmailIdValueResolver implements ValueResolverInterface
{
    private const ROUTE_PLACEHOLDER = 'emailId';

    /**
     * @return iterable<EmailId>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->isVariadic() || EmailId::class !== $argument->getType()) {
            return [];
        }

        $value = $request->attributes->get(self::ROUTE_PLACEHOLDER);

        if (!\is_string($value)) {
            return [];
        }

        try {
            return [EmailId::fromString($value)];
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
