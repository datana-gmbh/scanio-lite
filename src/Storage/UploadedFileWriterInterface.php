<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadedFileWriterInterface
{
    /**
     * Return the filename without any path.
     */
    public function write(UploadedFile $file): string;
}
