<?php

declare(strict_types=1);

namespace App\Bridge\Dropbox\Domain\Value;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type DropboxResponse array{
 *       '.tag': string,
 *       'name': string,
 *       'path_lower': string,
 *       'path_display': string,
 *       'id': string,
 *       'client_modified'?: string,
 *       'server_modified'?: string,
 *       'rev'?: string,
 *       'size'?: int,
 *       'is_downloadable'?: bool,
 *       'content_hash'?: string
 * }
 */
final readonly class FilesystemElement
{
    private function __construct(
        public string $name,
        public bool $isDir,
        public string $path,
        public bool $isDownloadable,
    ) {
    }

    /**
     * @param DropboxResponse $response
     */
    public static function fromResponse(array $response): self
    {
        Assert::keyExists($response, 'name');
        Assert::notNull($response['name']);
        $name = TrimmedNonEmptyString::fromString($response['name']);

        Assert::keyExists($response, '.tag');
        Assert::notNull($response['.tag']);
        $isDir = 'folder' === $response['.tag'];

        Assert::keyExists($response, 'path_lower');
        Assert::notNull($response['path_lower']);
        $path = TrimmedNonEmptyString::fromString($response['path_lower']);

        $isDownloadable = false;

        if (!$isDir) {
            Assert::keyExists($response, 'is_downloadable');
            Assert::notNull($response['is_downloadable']);
            Assert::boolean($response['is_downloadable']);
            $isDownloadable = $response['is_downloadable'];
        }

        return new self(
            $name->toString(),
            $isDir,
            $path->toString(),
            $isDownloadable,
        );
    }
}
