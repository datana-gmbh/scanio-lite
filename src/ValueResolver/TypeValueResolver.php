<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Domain\Enum\Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class TypeValueResolver implements ValueResolverInterface
{
    private const ROUTE_PLACEHOLDER = 'type';

    /**
     * @return Type[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->isVariadic() || Type::class !== $argument->getType()) {
            return [];
        }

        $value = $request->attributes->get($argument->getName(), $request->attributes->get(self::ROUTE_PLACEHOLDER));

        if (!\is_string($value)) {
            return [];
        }

        try {
            return [Type::from($value)];
        } catch (\ValueError) {
            throw new NotFoundHttpException(sprintf('Type "%s" not found.', $value));
        }
    }
}
