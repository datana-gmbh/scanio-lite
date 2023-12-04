<?php

declare(strict_types=1);

namespace App\Crud\Domain\Value;

use Webmozart\Assert\Assert;

final readonly class Pagination
{
    public int $offset;
    public int $totalPages;

    public function __construct(
        public int $page,
        public int $totalItems,
        public int $limit = 20,
    ) {
        Assert::greaterThan($page, 0);

        $this->offset = ($this->page - 1) * $this->limit;
        $this->totalPages = (int) ceil($this->totalItems / $this->limit);
    }

    public function hasNextPage(): bool
    {
        return $this->page + 1 <= $this->totalPages;
    }

    public function hasPreviousPage(): bool
    {
        return 1 !== $this->page;
    }

    public function nextPage(): int
    {
        return $this->page + 1;
    }

    public function previousPage(): int
    {
        return $this->page - 1;
    }
}
