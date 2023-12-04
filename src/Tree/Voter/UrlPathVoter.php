<?php

declare(strict_types=1);

namespace App\Tree\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class UrlPathVoter implements VoterInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function matchItem(ItemInterface $item): ?bool
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return null;
        }

        $parameters = $request->attributes->get('_route_params');
        $nodeParameters = $item->getExtra('_route_params');

        if (\is_array($parameters)
            && \array_key_exists('venture', $parameters)
            && \array_key_exists('type', $parameters)
            && \is_array($nodeParameters)
            && \array_key_exists('venture', $nodeParameters)
            && \array_key_exists('type', $nodeParameters)
        ) {
            return $parameters['venture'] === $nodeParameters['venture']
                && $parameters['type'] === $nodeParameters['type'];
        }

        return $item->getExtra('url_path') === $request->getPathInfo();
    }
}
