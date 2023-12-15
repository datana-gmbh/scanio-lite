<?php

declare(strict_types=1);

namespace App\Source\Filesystem;

use App\Entity\Source;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class FilesystemFactory
{
    /**
     * @var FilesystemInterface[]
     */
    private readonly array $filesystems;

    /**
     * @param iterable<FilesystemInterface> $filesystems
     */
    public function __construct(
        #[TaggedIterator(tag: FilesystemInterface::class)]
        iterable $filesystems,
    ) {
        $this->filesystems = $filesystems instanceof \Traversable ? iterator_to_array($filesystems) : $filesystems;
    }

    public function forSource(Source $source): FilesystemInterface
    {
        foreach ($this->filesystems as $filesystem) {
            if ($filesystem->supports($source)) {
                return $filesystem;
            }
        }

        throw new \InvalidArgumentException(sprintf('Cannot find Importer for Source: %s', $source));
    }
}
