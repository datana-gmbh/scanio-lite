<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Crud\List\Query\QueryFactoryInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;

final readonly class CategoryCounter implements CategoryCounterInterface
{
    public function __construct(
        private QueryFactoryInterface $queryFactory,
    ) {
    }

    public function count(Group $group, Category $type): ?int
    {
        if (!$type->showCountInTree()) {
            return null;
        }

        return $this->queryFactory->create($group, $type)->count();
    }
}
