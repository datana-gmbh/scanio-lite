<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<User>
 */
final class UserFactory extends ModelFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    public function asAdmin(): self
    {
        return $this->addState(['roles' => ['ROLE_ADMIN']]);
    }

    public function withRole(string $role): self
    {
        return $this->addState(['roles' => [$role]]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'password' => self::faker()->password(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (User $user): void {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            });
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
