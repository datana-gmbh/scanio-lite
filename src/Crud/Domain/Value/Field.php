<?php

declare(strict_types=1);

namespace App\Crud\Domain\Value;

use App\Crud\Domain\Enum\FieldType;

final class Field
{
    public bool $isSortable = false;

    public function __construct(
        public readonly FieldType $type,
        public readonly string $label,
        public readonly string $propertyPath,
    ) {
        $this->isSortable = false;
    }

    public function sortable(): self
    {
        $clone = clone $this;
        $clone->isSortable = true;

        return $clone;
    }
}
