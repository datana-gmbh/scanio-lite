<?php

declare(strict_types=1);

namespace App\Source\Filesystem;

use App\Entity\Source;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::class)]
interface FilesystemInterface
{
    public function create(Source $source): FilesystemOperator;

    public function supports(Source $source): bool;
}
