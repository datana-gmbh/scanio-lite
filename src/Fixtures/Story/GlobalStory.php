<?php

declare(strict_types=1);

namespace App\Fixtures\Story;

use App\Fixtures\Factory\UserFactory;
use Zenstruck\Foundry\Story;

final class GlobalStory extends Story
{
    public function build(): void
    {
        UserFactory::new([
            'username' => 'admin',
            'email' => 'admin@scanio.wip',
            'password' => 'admin',
        ])->asAdmin()->create();
    }
}
