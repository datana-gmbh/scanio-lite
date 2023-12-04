<?php

declare(strict_types=1);

namespace App\Crud\Domain\Value;

use App\Crud\Domain\Enum\SortDirection;

final readonly class Sorting
{
    public function __construct(
        public string $property,
        public SortDirection $direction,
    ) {
    }
}
