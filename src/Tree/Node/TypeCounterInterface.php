<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;

interface TypeCounterInterface
{
    public function count(Venture $venture, Type $type): ?int;
}
