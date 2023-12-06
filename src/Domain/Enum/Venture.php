<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;

/**
 * @todo Rename to Group
 */
enum Venture: string
{
    use Comparable;

    case Default = 'default';

    public function label(): string
    {
        return match ($this) {
            self::Default => 'Standard',
        };
    }
}
