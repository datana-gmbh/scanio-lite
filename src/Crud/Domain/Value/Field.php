<?php

declare(strict_types=1);

namespace App\Crud\Domain\Value;

use App\Crud\Domain\Enum\FieldType;

final readonly class Field
{
    public bool $isSortable;

    public function __construct(
        public FieldType $type,
        public string $label,
        public string $propertyPath,
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
