<?php

declare(strict_types=1);

namespace App\Crud\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;

enum SortDirection: string
{
    use Comparable;

    case ASC = 'ASC';
    case DESC = 'DESC';
}
