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
            && \array_key_exists('group', $parameters)
            && \array_key_exists('category', $parameters)
            && \is_array($nodeParameters)
            && \array_key_exists('group', $nodeParameters)
            && \array_key_exists('category', $nodeParameters)
        ) {
            return $parameters['group'] === $nodeParameters['group']
                && $parameters['category'] === $nodeParameters['category'];
        }

        return $item->getExtra('url_path') === $request->getPathInfo();
    }
}
