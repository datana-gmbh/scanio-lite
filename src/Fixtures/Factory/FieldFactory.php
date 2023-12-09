<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\Field;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Field>
 */
final class FieldFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        $faker = self::faker();

        return [
            'name' => self::faker()->word(),
            'condition' => $faker->boolean()
                ? null
                : $faker->randomElement([
                    'document.group == "default"',
                ]),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(Field $user): void {})
    }

    protected static function getClass(): string
    {
        return Field::class;
    }
}
