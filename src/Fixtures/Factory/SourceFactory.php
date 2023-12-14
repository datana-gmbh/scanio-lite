<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\Source;
use App\Source\Value\Type;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Source>
 */
final class SourceFactory extends ModelFactory
{
    public function dropbox(): self
    {
        return $this->addState([
            'type' => Type::Dropbox,
            'token' => self::faker()->md5(),
            'path' => self::faker()->filePath(),
        ]);
    }

    public function local(): self
    {
        return $this->addState([
            'type' => Type::Local,
            'path' => self::faker()->filePath(),
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'type' => Type::Local,
            'path' => self::faker()->filePath(),
            'enabled' => self::faker()->boolean(),
            'recursiveImport' => self::faker()->boolean(),
            'deleteAfterImport' => self::faker()->boolean(),
        ];
    }

    protected static function getClass(): string
    {
        return Source::class;
    }
}
