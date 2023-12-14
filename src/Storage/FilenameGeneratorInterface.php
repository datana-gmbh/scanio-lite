<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FilenameGeneratorInterface
{
    public function generate(null|string|UploadedFile $file = null): string;
}
