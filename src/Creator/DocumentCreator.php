<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Document;
use App\Repository\DocumentRepositoryInterface;
use App\Storage\TempFileWriterInterface;
use App\Storage\UploadedFileWriterInterface;
use Safe\DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class DocumentCreator implements DocumentCreatorInterface
{
    public function __construct(
        private TempFileWriterInterface $tempFileWriter,
        private UploadedFileWriterInterface $uploadedFileWriter,
        private DocumentRepositoryInterface $documents,
    ) {
    }

    public function create(string $originalFilename, mixed $content): Document
    {
        if (!\is_resource($content) && !\is_string($content)) {
            throw new \InvalidArgumentException('$content must be a resource or a string');
        }

        $tempFilepath = $this->tempFileWriter->write($content);
        $filename = $this->uploadedFileWriter->write(
            new UploadedFile($tempFilepath, $originalFilename),
        );

        $document = new Document(
            filename: $filename,
            originalFilename: $originalFilename,
        );
        $document->setInboxDate(new DateTimeImmutable());

        $this->documents->save($document);

        return $document;
    }
}
