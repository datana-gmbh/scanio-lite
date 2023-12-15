<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Bridge\Dropbox\ClientFactory;
use App\Bridge\Dropbox\Domain\Value\DropboxResource;
use App\Creator\DocumentCreatorInterface;
use App\Entity\Source;
use App\Source\Value\Type;
use Psr\Log\LoggerInterface;

final readonly class DropboxImporter implements ImporterInterface
{
    public function __construct(
        private ClientFactory $clientFactory,
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

        /** @var string $token */
        $token = $source->getToken();
        $client = $this->clientFactory->create($token);

        /** @var string $path */
        $path = $source->getPath();

        $response = $client->listFolder($path, $source->recursiveImport());

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