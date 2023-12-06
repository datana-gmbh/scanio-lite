<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Routing\Routes;
use App\Tree\Domain\Value\Node;

final readonly class TypeNodeFactory
{
    public function __construct(
        private TypeCounterInterface $counter,
    ) {
    }

    public function create(Venture $venture, Type $type): Node
    {
        return Node::new(sprintf('%s-%s', $venture->value, $type->value))
            ->route(Routes::LIST, ['venture' => $venture, 'type' => $type])
            ->label($type->label())
            ->count($this->counter->count($venture, $type))
            ->icon($type->icon());
    }
}
