<?php

declare(strict_types=1);

namespace App\Source\Importer;

use App\Entity\Document;
use App\Entity\Source;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::class)]
interface ImporterInterface
{
    /**
     * @return Document[]
     */
    public function import(Source $source): array;

    public function supports(Source $source): bool;
}
