<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Creator\DocumentCreatorInterface;
use App\Entity\Source;
use App\Source\Value\Type;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

final readonly class LocalImporter implements ImporterInterface
{
    public function __construct(
        private Filesystem $filesystem,
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

        foreach ($finder->getIterator() as $file) {
            try {
                $documents[] = $this->documentCreator->create(
                    $file->getFilename(),
                    $file->getContents(),
                    (string) $source,
                );

                $this->logger->info('Created Document', [
                    'path' => $file->getRealPath(),
                ]);

                if ($source->deleteAfterImport()) {
                    $this->filesystem->remove($file->getRealPath());

                    $this->logger->info('Deleted local file', [
                        'path' => $file->getRealPath(),
                    ]);
                }
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $documents;
    }
}
