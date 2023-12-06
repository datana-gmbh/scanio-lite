<?php

declare(strict_types=1);

namespace App\Tree;

use App\Tree\Domain\Value\Node;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class NodeToMenuItemConverter
{
    public function __construct(
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function from(Node $node, FactoryInterface $factory): ItemInterface
    {
        $converted = new MenuItem($node->name, $factory);
        $converted->setExtra('icon', $node->getIcon());
        $converted->setExtra('count', $node->getCount());
        $converted->setExtra('show_count', $node->showCount());

        if ($node->isEnabled()) {
            $converted->setLinkAttribute('class', 'done');
        }

        if (null !== $node->getLabel()) {
            $converted->setLabel($this->translator->trans($node->getLabel()));
        }

        if (null !== $node->getRoute()) {
            $urlPath = $this->urlGenerator->generate($node->getRoute(), $node->getRouteParameters());
            $converted->setUri($urlPath);
            $converted->setExtra('url_path', $urlPath);
            $converted->setExtra('_route_params', $node->getRouteParameters());
        }

        foreach ($node->getChildren() as $child) {
            if (!$child->canDisplay()) {
                continue;
            }

            $converted->addChild($this->from($child, $factory));
        }

        return $converted;
    }
}
