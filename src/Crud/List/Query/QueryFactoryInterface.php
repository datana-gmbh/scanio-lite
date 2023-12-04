<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;

interface QueryFactoryInterface
{
    public function create(Venture $venture, Type $type): QueryInterface;
}
