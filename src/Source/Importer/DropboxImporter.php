<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Creator\DocumentCreatorInterface;
use App\Entity\Source;
use App\Source\Filesystem\FilesystemFactory;
use App\Source\Value\Type;
use Psr\Log\LoggerInterface;

final readonly class DropboxImporter implements ImporterInterface
{
    public function __construct(
        private FilesystemFactory $filesystemFactory,
        private DocumentCreatorInterface $documentCreator,
        private LoggerInterface $logger,
    ) {
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Dropbox);
    }

    public function import(Source $source): array
    {
        if (!$source->isEnabled()) {
            $this->logger->info(sprintf(
                'Source %s: %s is not enabled.',
                $source->getType()->label(),
                $source->getPath(),
            ));

            return [];
        }

        $documents = [];

        $dropboxFactory = $this->filesystemFactory->forSource($source);
        $dropboxFilesystem = $dropboxFactory->create($source);

        /** @var string $path */
        $path = $source->getPath();

        $fileAttributes = $dropboxFilesystem->listContents($path, $source->recursiveImport())->toArray();

        $this->logger->debug(sprintf('Found files in %s', $path), [
            'number_of_files' => \count($fileAttributes),
        ]);

        foreach ($fileAttributes as $fileAttribute) {
            if ($fileAttribute->isDir()) {
                continue;
            }

            try {
                $filepath = $fileAttribute->path();
                $documents[] = $this->documentCreator->create(
                    basename($filepath),
                    $dropboxFilesystem->readStream($filepath),
                    (string) $source,
                );

                $this->logger->info('Created Document', [
                    'path' => $filepath,
                ]);

                if ($source->deleteAfterImport()) {
                    $dropboxFilesystem->delete($filepath);

                    $this->logger->info('Deleted remote file', [
                        'path' => $filepath,
                    ]);
                }
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $documents;
    }
}
