<?php

declare(strict_types=1);

namespace App\Crud\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;

enum FieldType: string
{
    use Comparable;

    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case TEXT = 'text';
    case INTEGER = 'integer';
    case URL = 'url';
    case ID = 'id';
}
