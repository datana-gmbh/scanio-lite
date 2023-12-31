<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Ulid;

final readonly class UniqueFilenameGenerator implements FilenameGeneratorInterface
{
    public function generate(null|string|UploadedFile $file = null): string
    {
        $hash = (new Ulid())->toBase32();

        if (null === $file) {
            return $hash;
        }

        if ($file instanceof UploadedFile) {
            return sprintf('%s.%s', $hash, $file->guessExtension());
        }

        return sprintf('%s.%s', $hash, pathinfo($file, \PATHINFO_EXTENSION));
    }
}
