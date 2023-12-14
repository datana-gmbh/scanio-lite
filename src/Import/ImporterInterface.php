<?php

declare(strict_types=1);

namespace App\Import;

use App\Entity\Document;
use App\Entity\Storage;

interface ImporterInterface
{
    /**
     * @return Document[]
     */
    public function import(Storage $storage): array;
}
