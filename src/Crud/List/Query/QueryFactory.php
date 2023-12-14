<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Crud\List\Query\Letter\DefaultDocumentQuery;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Repository\DocumentRepositoryInterface;

final readonly class QueryFactory implements QueryFactoryInterface
{
    public function __construct(
        private DocumentRepositoryInterface $documents,
    ) {
    }

    public function create(Group $group, Category $category): QueryInterface
    {
        return new DefaultDocumentQuery($this->documents, $category);
    }
}
