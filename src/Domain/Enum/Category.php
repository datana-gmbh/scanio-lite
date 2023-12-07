<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;
use function Symfony\Component\String\u;

/**
 * @todo rename to Category
 */
enum Category: string
{
    use Comparable;

    case Other = 'other';
    case Pending = 'pending';
    case Unknown = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::Other => 'Sonstiges',
            self::Pending => 'Unbearbeitet',
            self::Unknown => 'Unbekannt',
            default => u($this->value)
                ->replace('_', ' ')
                ->title(true)
                ->toString(),
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::Pending => 'fa-light fa-clipboard-list',
            self::Unknown => 'fa-light fa-square-question',
            default => null,
        };
    }

    public function showCountInTree(): bool
    {
        return match ($this) {
            default => true,
        };
    }
}
