<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Group;
use App\Domain\Enum\Type;

interface TypeCounterInterface
{
    public function count(Group $group, Type $type): ?int;
}
