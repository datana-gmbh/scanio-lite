<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Document;
use App\Repository\DocumentRepositoryInterface;
use App\Storage\TmpFileWriter;
use App\Storage\UploadedFileWriter;
use Safe\DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class DocumentCreator
{
    public function __construct(
        private TmpFileWriter $tmpFileWriter,
        private UploadedFileWriter $uploadedFileWriter,
        private DocumentRepositoryInterface $documents,
    ) {
    }

    public function fromResource(string $originalFilename, mixed $content): Document
    {
        if (!\is_resource($content)) {
            throw new \BadMethodCallException(sprintf(
                'Given content of file "%s" is not a resource.',
                $originalFilename,
            ));
        }

        $tmpFilepath = $this->tmpFileWriter->write($originalFilename, $content);
        $filename = $this->uploadedFileWriter->write(new UploadedFile($tmpFilepath, $originalFilename));

        $document = new Document(
            filename: $filename,
            originalFilename: $originalFilename,
        );

        $document->setInboxDate(new DateTimeImmutable());

        $this->documents->save($document);

        return $document;
    }
}
