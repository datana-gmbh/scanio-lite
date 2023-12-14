<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class SameFilenameGenerator implements FilenameGeneratorInterface
{
    public function generate(string|UploadedFile $file): string
    {
        if ($file instanceof UploadedFile) {
            return $file->getClientOriginalName();
        }

        return $file;
    }
}
