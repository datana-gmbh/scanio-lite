<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;
use function Symfony\Component\String\u;

/**
 * @todo rename to Category
 */
enum Type: string
{
    use Comparable;

    case OTHER = 'other';
    case PENDING = 'pending';
    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::OTHER => 'Sonstiges',
            self::PENDING => 'Unbearbeitet',
            self::UNKNOWN => 'Unbekannt',
            default => u($this->value)
                ->replace('_', ' ')
                ->title(true)
                ->toString(),
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::PENDING => 'fa-light fa-clipboard-list',
            self::UNKNOWN => 'fa-light fa-square-question',
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
