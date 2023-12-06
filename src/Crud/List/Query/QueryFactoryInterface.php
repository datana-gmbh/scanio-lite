<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Domain\Enum\Group;
use App\Domain\Enum\Type;

interface QueryFactoryInterface
{
    public function create(Group $group, Type $type): QueryInterface;
}
