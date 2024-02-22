<?php

declare(strict_types=1);

namespace App\Source\Value;

use OskarStark\Enum\Trait\Comparable;
use function Symfony\Component\String\u;

enum Type: string
{
    use Comparable;

    case Azure = 'azure';
    case Dropbox = 'dropbox';
    case Local = 'local';

    public function label(): string
    {
        return match ($this) {
            self::Azure => 'Azure Blob Storage',
            self::Dropbox => 'Dropbox',
            self::Local => 'Lokal',
            default => u($this->value)
                ->replace('_', ' ')
                ->title(true)
                ->toString(),
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::Azure => 'fa-brands fa-microsoft',
            self::Dropbox => 'fa-brands fa-dropbox',
            self::Local => 'fa-light fa-folder',
            default => null,
        };
    }
}
