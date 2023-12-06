<?php

declare(strict_types=1);

namespace App\Tree;

use App\Tree\Domain\Value\Node;
use App\Tree\Node\NodeBuilderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class TreeBuilder
{
    /**
     * @var NodeBuilderInterface[]
     */
    private readonly array $builders;

    /**
     * @param iterable<NodeBuilderInterface> $builders
     */
    public function __construct(
        #[TaggedIterator(tag: NodeBuilderInterface::class, defaultPriorityMethod: 'priority')]
        iterable $builders,
    ) {
        $this->builders = $builders instanceof \Traversable ? iterator_to_array($builders) : $builders;
    }

    /**
     * @return Node[]
     */
    public function build(): array
    {
        $nodes = [];

        foreach ($this->builders as $key => $builder) {
            $node = $builder->build();

            if ($node->canDisplay()) {
                $nodes[$key] = $node;
            }
        }

        return $nodes;
    }
}
