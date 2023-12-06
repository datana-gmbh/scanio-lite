<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Domain\Enum\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class GroupValueResolver implements ValueResolverInterface
{
    private const ROUTE_PLACEHOLDER = 'group';

    /**
     * @return Group[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->isVariadic() || Group::class !== $argument->getType()) {
            return [];
        }

        $value = $request->attributes->get($argument->getName(), $request->attributes->get(self::ROUTE_PLACEHOLDER));

        if (!\is_string($value)) {
            return [];
        }

        try {
            return [Group::from($value)];
        } catch (\ValueError) {
            throw new NotFoundHttpException(sprintf('Group "%s" not found.', $value));
        }
    }
}
