<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Entity\Source;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class ImporterFactory
{
    /**
     * @var ImporterInterface[]
     */
    private readonly array $importers;

    /**
     * @param iterable<ImporterInterface> $importers
     */
    public function __construct(
        #[TaggedIterator(tag: ImporterInterface::class)]
        iterable $importers,
    ) {
        $this->importers = $importers instanceof \Traversable ? iterator_to_array($importers) : $importers;
    }

    public function forSource(Source $source): ImporterInterface
    {
        foreach ($this->importers as $importer) {
            if ($importer->supports($source)) {
                return $importer;
            }
        }

        throw new \InvalidArgumentException(sprintf('Cannot find Importer for Source: %s', $source));
    }
}
