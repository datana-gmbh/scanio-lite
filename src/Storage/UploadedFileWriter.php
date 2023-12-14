<?php

declare(strict_types=1);

namespace App\Storage;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Safe\fclose;
use function Safe\fopen;

final readonly class UploadedFileWriter implements UploadedFileWriterInterface
{
    public function __construct(
        private FilesystemOperator $documentsStorage,
    ) {
    }

    public function write(UploadedFile $file): string
    {
        if ($file->isValid()) {
            throw new \RuntimeException('Invalid file');
        }

        if ($this->documentsStorage->fileExists($file->getClientOriginalName())) {
            throw new \RuntimeException('File already exists');
        }

        $stream = fopen($file->getRealPath(), 'r+');
        $this->documentsStorage->writeStream($file->getClientOriginalName(), $stream);
        fclose($stream);

        return $file->getClientOriginalName();
    }
}
