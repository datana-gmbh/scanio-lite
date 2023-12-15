<?php

declare(strict_types=1);

namespace App\Bridge\Dropbox;

use Spatie\Dropbox\Client;

final class ClientFactory
{
    public function create(string $token): Client
    {
        return new Client($token);
    }
}
