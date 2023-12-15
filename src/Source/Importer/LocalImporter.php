<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Bridge\Dropbox\Domain\Value\DropboxResource;
use App\Creator\DocumentCreatorInterface;
use App\Entity\Source;
use App\Source\Value\Type;
use Psr\Log\LoggerInterface;
use Spatie\Dropbox\Client;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final readonly class LocalImporter implements ImporterInterface
{
    public function __construct(
        private Filesystem $filesystem = new Filesystem(),
        private DocumentCreatorInterface $documentCreator,
        private LoggerInterface $logger,
    ) {
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Local);
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

        /** @var string $path */
        $path = $source->getPath();

        $finder = (new Finder())
            ->in($path)
            ->files();

        $files = $finder->getIterator();

        $this->logger->debug(sprintf('Found files in %s', $path), [
            'number_of_files' => \count($files),
        ]);

        // Maps all entries to FilesystemElement and filter only files.
        // Dropbox returns already flattened array of all files in all subdirectories.
        $resources = array_filter(
            array_map(static fn (array $entry): DropboxResource => DropboxResource::fromResponse($entry), $response['entries']),
            static fn (DropboxResource $resource): bool => !$resource->isDir,
        );

        foreach ($resources as $resource) {
            if (!$resource->isDownloadable) {
                $this->logger->debug(sprintf('File %s is not downloadable', $resource->name));

                continue;
            }

            try {
                $documents[] = $this->documentCreator->create(
                    $resource->name,
                    $client->download($resource->path),
                );

                $this->logger->info('Created Document', [
                    'path' => $resource->path,
                ]);

                if ($source->deleteAfterImport()) {
                    $client->delete($resource->path);

                    $this->logger->info('Deleted remote file', [
                        'path' => $resource->path,
                    ]);
                }
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $documents;
    }
}
