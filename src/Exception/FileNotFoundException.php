<?php

declare(strict_types=1);

namespace App\Exception;

final class FileNotFoundException extends NotFoundException
{
    public static function forFilepath(string $filepath): self
    {
        return new self(sprintf(
            'File not found: %s',
            $filepath,
        ));
    }
}
