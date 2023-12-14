<?php

declare(strict_types=1);

namespace App\Storage;

interface TempFileWriterInterface
{
    /**
     * Return the absolute filepath to the temp file.
     *
     * @param resource|string $content
     */
    public function write(mixed $content): string;
}
