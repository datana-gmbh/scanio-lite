<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Document;

interface DocumentCreatorInterface
{
    public function fromResource(string $originalFilename, mixed $content): Document;
}
