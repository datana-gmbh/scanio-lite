<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;

enum Group: string
{
    use Comparable;

    case Default = 'default';
    case Emails = 'emails';

    public function label(): string
    {
        return match ($this) {
            self::Default => 'Standard',
            self::Emails => 'E-Mails',
        };
    }
}
