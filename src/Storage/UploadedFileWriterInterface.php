<?php

declare(strict_types=1);

namespace App\Storage;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadedFileWriterInterface
{
    public function write(UploadedFile $file): string;
}
