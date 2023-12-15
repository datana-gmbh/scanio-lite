<?php

declare(strict_types=1);

namespace App\Source\Filesystem;

use App\Entity\Source;
use App\Source\Value\Type;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Webmozart\Assert\Assert;

final class DropboxFilesystem implements FilesystemInterface
{
    public function create(Source $source): FilesystemOperator
    {
        Assert::notNull($source->getToken());

        $client = new Client($source->getToken());

        return new Filesystem(
            new DropboxAdapter($client),
            ['case_sensitive' => false],
        );
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Dropbox);
    }
}
