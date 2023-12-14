<?php

declare(strict_types=1);

namespace App\Storage;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadedFileWriter implements UploadedFileWriterInterface
{
    public function __construct(
        private readonly FilesystemOperator $documentsStorage,
    ) {
    }

    public function write(UploadedFile $file): string
    {
        if ($file->isValid()) {
            throw new \RuntimeException('Invalid file');
        }

        $stream = \Safe\fopen($file->getRealPath(), 'r+');
        $this->documentsStorage->writeStream($file->getClientOriginalName(), $stream);
        \Safe\fclose($stream);

        return $file->getClientOriginalName();
    }
}
