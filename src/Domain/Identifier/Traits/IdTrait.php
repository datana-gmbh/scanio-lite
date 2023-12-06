<?php

declare(strict_types=1);

namespace App\Domain\Identifier\Traits;

trait IdTrait
{
    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->toBase32();
    }
}
