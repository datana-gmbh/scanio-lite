<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\User;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<User>
 */
final class UserFactory extends ModelFactory
{
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
            'username' => self::faker()->userName(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(User $user): void {})
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
