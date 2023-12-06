<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Crud\Domain\Value\Pagination;
use App\Crud\Domain\Value\Sorting;
use App\Crud\List\ListResult;

interface QueryInterface
{
    public function count(): int;

    /**
     * @param Sorting[] $sortings
     */
    public function execute(Pagination $pagination, array $sortings): ListResult;
}
