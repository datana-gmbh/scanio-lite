<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadedFileWriterInterface
{
    public function write(UploadedFile $file): string;
}
