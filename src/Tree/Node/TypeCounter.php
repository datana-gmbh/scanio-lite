<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Crud\List\Query\QueryFactoryInterface;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;

final readonly class TypeCounter implements TypeCounterInterface
{
    public function __construct(
        private QueryFactoryInterface $queryFactory,
    ) {
    }

    public function count(Venture $venture, Type $type): ?int
    {
        if (!$type->showCountInTree()) {
            return null;
        }

        return $this->queryFactory->create($venture, $type)->count();
    }
}
