<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Ulid;

final readonly class SameFilenameGenerator implements FilenameGeneratorInterface
{
    public function generate(null|string|UploadedFile $file = null): string
    {
        if (null === $file) {
            return (new Ulid())->toBase32();
        }

        if ($file instanceof UploadedFile) {
            return $file->getClientOriginalName();
        }

        return $file;
    }
}
