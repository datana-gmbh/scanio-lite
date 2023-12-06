<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Group;
use App\Domain\Enum\Type;
use App\Routing\Routes;
use App\Tree\Domain\Value\Node;

final readonly class TypeNodeFactory
{
    public function __construct(
        private TypeCounterInterface $counter,
    ) {
    }

    public function create(Group $group, Type $type): Node
    {
        return Node::new(sprintf('%s-%s', $group->value, $type->value))
            ->route(Routes::LIST, ['group' => $group, 'type' => $type])
            ->label($type->label())
            ->count($this->counter->count($group, $type))
            ->icon($type->icon());
    }
}
