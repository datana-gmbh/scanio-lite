<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;

interface CategoryCounterInterface
{
    public function count(Group $group, Category $type): ?int;
}
