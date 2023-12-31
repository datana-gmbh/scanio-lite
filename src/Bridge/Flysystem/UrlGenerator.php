<?php

declare(strict_types=1);

namespace App\Bridge\Flysystem;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

final readonly class UrlGenerator
{
    public function __construct(
        private string $storagePath,
        private string $storageCdnPath,
    ) {
    }

    /**
     * This method handles the replacement of the absolute URLs with the configured CDN path.
     */
    public function relativeUrl(string $path): string
    {
        $path = TrimmedNonEmptyString::fromString($path)->toString();
        Assert::startsWith($path, $this->storagePath);

        return str_replace($this->storagePath, $this->storageCdnPath, $path);
    }
}
