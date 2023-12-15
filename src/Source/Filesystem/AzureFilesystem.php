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
use function Symfony\Component\String\u;

final class AzureFilesystem implements FilesystemInterface
{
    public function create(Source $source): FilesystemOperator
    {
        Assert::notNull($source->getToken());
        Assert::notNull($source->getPath());

        $containerName = null;
        $token = null;

        foreach (u($source->getToken())->split(';') as $part) {
            $keyValue = $part->split('=');

            if ($keyValue[0]->equalsTo('ContainerName')) {
                $containerName = $keyValue[1]->toString();
                $token = u($source->getToken())->replace($part->toString(), '')->toString();

                break;
            }
        }

        Assert::notNull($containerName);
        Assert::notNull($token);

        $client = BlobRestProxy::createBlobService($token);

        $adapter = new AzureBlobStorageAdapter(
            $client,
            $containerName,
        );

        return new Filesystem($adapter);
    }

    public function supports(Source $source): bool
    {
        return $source->getType()->equals(Type::Azure);
    }
}
