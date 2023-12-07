<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;

interface QueryFactoryInterface
{
    public function create(Group $group, Category $category): QueryInterface;
}
