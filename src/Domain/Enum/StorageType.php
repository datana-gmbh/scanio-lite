<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;
use function Symfony\Component\String\u;

enum StorageType: string
{
    use Comparable;

    case Local = 'local';
    case Dropbox = 'dropbox';

    public function label(): string
    {
        return match ($this) {
            self::Local => 'Lokal',
            self::Dropbox => 'Dropbox',
            default => u($this->value)
                ->replace('_', ' ')
                ->title(true)
                ->toString(),
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::Local => 'fa-light fa-folder',
            self::Dropbox => 'fa-brands fa-dropbox',
            default => null,
        };
    }
}
