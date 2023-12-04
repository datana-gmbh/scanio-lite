<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Tree\Domain\Value\Node;

abstract class AbstractNodeBuilder implements NodeBuilderInterface
{
    final public function build(): Node
    {
        $node = Node::new(static::name())->label(static::label());

        return $this->configure($node);
    }

    abstract protected function configure(Node $node): Node;

    abstract protected static function name(): string;

    abstract protected static function label(): string;
}
