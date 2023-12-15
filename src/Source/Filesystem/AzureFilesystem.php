<?php

declare(strict_types=1);

namespace App\Source\Filesystem;

use App\Entity\Source;
use App\Source\Value\Type;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Webmozart\Assert\Assert;

final class AzureFilesystem implements FilesystemInterface
{
    public function create(Source $source): FilesystemOperator
    {
        Assert::notNull($source->getToken());
        Assert::notNull($source->getPath());

        $client = BlobRestProxy::createBlobService($source->getToken());
        $adapter = new AzureBlobStorageAdapter(
            $client,
            $source->getPath(),
        );

        return new Filesystem($adapter);
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Azure);
    }
}
