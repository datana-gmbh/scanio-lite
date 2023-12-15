<?php

declare(strict_types=1);

namespace App\Source\Filesystem;

use App\Bridge\Azure\Domain\Value\AzureDsn;
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

        $azureDsn = new AzureDsn($source->getToken());
        $client = BlobRestProxy::createBlobService($azureDsn->raw);
        $adapter = new AzureBlobStorageAdapter(
            $client,
            $azureDsn->containerName,
        );

        return new Filesystem($adapter);
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Azure);
    }
}
