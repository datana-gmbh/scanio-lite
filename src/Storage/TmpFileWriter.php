<?php

declare(strict_types=1);

namespace App\Storage;

use Symfony\Component\Filesystem\Filesystem;

final readonly class TmpFileWriter
{
    public function __construct(
        // league/flysystem does not support absolute paths so we use here symfony/filesystem
        private Filesystem $filesystem = new Filesystem(),
    ) {
    }

    /**
     * @param resource|string $content
     */
    public function write(string $filename, mixed $content): string
    {
        $filepath = sprintf('%s/%s', sys_get_temp_dir(), $filename);

        $this->filesystem->dumpFile($filepath, $content);

        return $filepath;
    }
}
