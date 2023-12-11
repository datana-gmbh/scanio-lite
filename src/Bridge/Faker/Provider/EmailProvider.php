<?php

declare(strict_types=1);

namespace App\Bridge\Faker\Provider;

use Faker\Provider\Base as BaseProvider;
use function Symfony\Component\String\u;

final class EmailProvider extends BaseProvider
{
    public function emailOrNonCanonicalEmail(): string
    {
        if ($this->generator->boolean()) {
            return $this->generator->email();
        }

        return $this->nonCanonicalEmail();
    }

    public function nonCanonicalEmail(): string
    {
        $email = $this->generator->email();

        return sprintf(
            '%s%s%s',
            u($email)->slice(0, 1)->upper()->toString(),
            u($email)->slice(1, -1)->upper()->toString(),
            u($email)->slice(-1)->upper()->toString(),
        );
    }
}
