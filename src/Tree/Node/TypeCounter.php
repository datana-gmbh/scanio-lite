<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Crud\List\Query\QueryFactoryInterface;
use App\Domain\Enum\Group;
use App\Domain\Enum\Type;

final readonly class TypeCounter implements TypeCounterInterface
{
    public function __construct(
        private QueryFactoryInterface $queryFactory,
    ) {
    }

    public function count(Group $group, Type $type): ?int
    {
        if (!$type->showCountInTree()) {
            return null;
        }

        return $this->queryFactory->create($group, $type)->count();
    }
}
