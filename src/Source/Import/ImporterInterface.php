<?php

declare(strict_types=1);

namespace App\Source\Import;

use App\Entity\Document;
use App\Entity\Source;

interface ImporterInterface
{
    /**
     * @return Document[]
     */
    public function import(Source $storage): array;
}
