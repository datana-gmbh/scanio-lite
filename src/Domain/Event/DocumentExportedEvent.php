<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Entity\Document;
use Symfony\Contracts\EventDispatcher\Event;

final class DocumentExportedEvent extends Event
{
    public const string NAME = 'document.exported';

    public function __construct(
        public readonly Document $document,
    ) {
    }
}
