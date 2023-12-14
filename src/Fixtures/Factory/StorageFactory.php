<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\Storage;
use App\Entity\User;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<User>
 */
final class StorageFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
        ];
    }

    protected static function getClass(): string
    {
        return Storage::class;
    }
}
