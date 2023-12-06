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

    case KEINE_ZUORDNUNG_MOEGLICH = 'keine_zuordnung_moeglich';
    case SONSTIGES = 'sonstiges';
    case UNBEARBEITET = 'pending';
    case UNBEKANNT = 'unknown';
    case UNVOLLSTAENDIG = 'unvollstaendig';

    public function label(): string
    {
        return match ($this) {
            self::KEINE_ZUORDNUNG_MOEGLICH => 'Keine Zuordnung möglich',
            self::UNBEARBEITET => 'Unbearbeitet',
            self::UNBEKANNT => 'Unbekannt',
            self::UNVOLLSTAENDIG => 'Unvollständig',
            default => u($this->value)
                ->replace('_', ' ')
                ->title(true)
                ->toString(),
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::UNBEARBEITET => 'fa-light fa-clipboard-list',
            self::UNBEKANNT => 'fa-light fa-square-question',
            self::UNVOLLSTAENDIG => 'fa-light fa-square-exclamation',
            default => null,
        };
    }

    public function status(): string
    {
        return match ($this) {
            default => u($this->value)->replace('_', ' ')->camel()->toString(),
        };
    }

    public function showCountInTree(): bool
    {
        return match ($this) {
            self::LOESCHLISTE, self::UEBERTRAGEN => false,
            default => true,
        };
    }
}
