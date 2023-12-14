<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\Filesystem\Filesystem;
use Webmozart\Assert\Assert;

final readonly class TempFileWriter implements TempFileWriterInterface
{
    public function __construct(
        private FilenameGeneratorInterface $filenameGenerator,
        private Filesystem $filesystem = new Filesystem(),
    ) {
    }

    public function write(mixed $content): string
    {
        if (!\is_string($content) && !\is_resource($content)) {
            throw new \InvalidArgumentException('Argument "$content" must be of type string or resource.');
        }

        $filepath = sprintf(
            '%s/%s',
            sys_get_temp_dir(),
            $this->filenameGenerator->generate(),
        );

        $this->filesystem->dumpFile($filepath, $content);

        Assert::fileExists($filepath);

        return $filepath;
    }
}
