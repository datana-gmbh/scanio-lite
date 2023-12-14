<?php

declare(strict_types=1);

namespace App\Source\Import;

use App\Bridge\Dropbox\Domain\Value\DropboxResource;
use App\Creator\DocumentCreatorInterface;
use App\Entity\Source;
use App\Source\Value\Type;
use Psr\Log\LoggerInterface;
use Spatie\Dropbox\Client;

final readonly class DropboxImporter implements ImporterInterface
{
    public function __construct(
        private DocumentCreatorInterface $documentCreator,
        private LoggerInterface $logger,
    ) {
    }

    public function supports(Source $storage): bool
    {
        return $storage->getType()->equals(Type::Dropbox);
    }

    public function import(Source $storage): array
    {
        if (!$storage->isEnabled()) {
            $this->logger->info(sprintf(
                'Storage %s: %s is not enabled.',
                $storage->getType()->label(),
                $storage->getPath(),
            ));

            return [];
        }

        $documents = [];

        $client = new Client($storage->getToken());
        /** @var string $path */
        $path = $storage->getPath();

        // removes all values which are no array. Somehow it can happen that there are strings.
        $response = array_filter(
            $client->listFolder($path, $storage->recursiveImport()),
            static fn (array|string $item): bool => \is_array($item),
        );

        $this->logger->debug(sprintf('Found files in %s', $path), [
            'number_of_files' => \count($response['entries']),
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

                if ($storage->deleteAfterImport()) {
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
