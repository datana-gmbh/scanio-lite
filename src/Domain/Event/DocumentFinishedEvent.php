<?php

declare(strict_types=1);

namespace App\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class DocumentFinishedEvent extends Event
{
    public const string NAME = 'document.finished';

    public function __construct(
        public readonly \App\Entity\Document $document,
    ) {
    }
}
