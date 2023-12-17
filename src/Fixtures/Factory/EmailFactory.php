<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\Email;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Email>
 */
final class EmailFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        $faker = self::faker();

        return [
            'from' => $faker->email(),
            'receiver' => $faker->companyEmail(),
            'subject' => $faker->sentence(),
            'body' => $faker->realText($faker->numberBetween(100, 500)),
        ];
    }

    protected static function getClass(): string
    {
        return Email::class;
    }
}
