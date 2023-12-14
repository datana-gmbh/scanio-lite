<?php

declare(strict_types=1);

namespace App\Storage;

use function Safe\fopen;
use function Safe\fclose;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $stream = fopen($file->getRealPath(), 'r+');
        $this->documentsStorage->writeStream($file->getClientOriginalName(), $stream);
        fclose($stream);

        return $file->getClientOriginalName();
    }
}