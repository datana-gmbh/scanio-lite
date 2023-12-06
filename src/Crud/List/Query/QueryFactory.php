<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Crud\List\Query\Letter\DefaultLetterQuery;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Repository\LetterRepositoryInterface;

final readonly class QueryFactory implements QueryFactoryInterface
{
    public function __construct(
        private LetterRepositoryInterface $letters,
    ) {
    }

    public function create(Group $group, Category $category): QueryInterface
    {
        return new DefaultLetterQuery($this->letters, $category);
    }
}
