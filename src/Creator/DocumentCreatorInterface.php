<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Document;

interface DocumentCreatorInterface
{
    /**
     * @param resource|string $content
     */
    public function create(string $originalFilename, mixed $content, string $source = null): Document;
}
