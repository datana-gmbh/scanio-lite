<?php

declare(strict_types=1);

namespace App\Crud\List;

use App\Crud\Domain\Value\Field;
use Webmozart\Assert\Assert;

final readonly class ListResult
{
    /**
     * @param Field[]                 $fields
     * @param array<int, list<mixed>> $rows
     */
    public function __construct(
        public array $fields,
        public array $rows,
    ) {
        Assert::notEmpty($this->fields);
    }

    public function hasRows(): bool
    {
        return \count($this->rows) > 0;
    }
}
