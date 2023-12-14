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
        private FilenameGeneratorInterface $filenameGenerator,
        private FilesystemOperator $documentsStorage,
    ) {
    }

    public function write(UploadedFile $file): string
    {
        $targetFilename = $this->filenameGenerator->generate($file);

        if ($this->documentsStorage->fileExists($targetFilename)) {
            throw new \RuntimeException('File already exists');
        }

        $stream = fopen($file->getRealPath(), 'r+');
        $this->documentsStorage->writeStream($targetFilename, $stream);
        fclose($stream);

        return $targetFilename;
    }
}
