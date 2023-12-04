<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Domain\Enum\Venture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class VentureValueResolver implements ValueResolverInterface
{
    private const ROUTE_PLACEHOLDER = 'venture';

    /**
     * @return Venture[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->isVariadic() || Venture::class !== $argument->getType()) {
            return [];
        }

        $value = $request->attributes->get($argument->getName(), $request->attributes->get(self::ROUTE_PLACEHOLDER));

        if (!\is_string($value)) {
            return [];
        }

        try {
            yield Venture::from($value);
        } catch (\ValueError) {
            throw new NotFoundHttpException(sprintf('Venture "%s" not found.', $value));
        }
    }
}
