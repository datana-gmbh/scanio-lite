<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Domain\Enum\StorageType;
use App\Entity\Storage;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Storage>
 */
final class StorageFactory extends ModelFactory
{
    public function dropbox(): self
    {
        return $this->addState([
            'storageType' => StorageType::Dropbox,
            'token' => self::faker()->md5(),
            'path' => self::faker()->filePath(),
        ]);
    }

    public function local(): self
    {
        return $this->addState([
            'storageType' => StorageType::Local,
            'path' => self::faker()->filePath(),
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'storageType' => StorageType::Local,
            'path' => self::faker()->filePath(),
            'enabled' => self::faker()->boolean(),
        ];
    }

    protected static function getClass(): string
    {
        return Storage::class;
    }
}
