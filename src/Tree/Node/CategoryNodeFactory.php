<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Routing\Routes;
use App\Tree\Domain\Value\Node;

final readonly class CategoryNodeFactory
{
    public function __construct(
        private CategoryCounterInterface $counter,
    ) {
    }

    public function create(Group $group, Category $category): Node
    {
        return Node::new(sprintf('%s-%s', $group->value, $category->value))
            ->route(Routes::LIST, ['group' => $group, 'category' => $category])
            ->label($category->label())
            ->count($this->counter->count($group, $category))
            ->icon($category->icon());
    }
}
