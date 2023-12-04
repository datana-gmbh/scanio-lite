<?php

declare(strict_types=1);

namespace App\Tree;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

final readonly class KnpMenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private TreeBuilder $builder,
        private NodeToMenuItemConverter $converter,
    ) {
    }

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem('app');

        foreach ($this->builder->build() as $branch) {
            $menu->addChild($this->converter->from($branch, $this->factory));
        }

        return $menu;
    }
}
