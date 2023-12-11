<?php

declare(strict_types=1);

namespace App\Fixtures\Story;

use App\Entity\User;
use App\Fixtures\Factory\UserFactory;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\Story;

final class GlobalStory extends Story
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function build(): void
    {
        UserFactory::new([
            'email' => 'admin@scanio.wip',
            'password' => $this->passwordHasherFactory->getPasswordHasher(User::class)->hash('admin'),
        ])->asAdmin()->create();
    }
}
