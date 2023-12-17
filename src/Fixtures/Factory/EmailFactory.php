<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Entity\Email;
use Safe\DateTimeImmutable;
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
            'to' => $faker->boolean(40)
                ? [
                    $faker->name() => $faker->companyEmail(),
                ]
                : [
                    $faker->name() => $faker->companyEmail(),
                    $faker->name() => $faker->companyEmail(),
                ],
            'subject' => $faker->sentence(),
            'body' => $faker->realText($faker->numberBetween(100, 500)),
            'createdAt' => DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 day')),
            'cc' => $faker->boolean(40)
                ? []
                : [
                    $faker->name() => $faker->companyEmail(),
                    $faker->name() => $faker->companyEmail(),
                ],
            'bcc' => $faker->boolean(40)
                ? []
                : [
                    $faker->name() => $faker->companyEmail(),
                    $faker->name() => $faker->companyEmail(),
                ],
            'headers' => $faker->boolean(10)
                ? []
                : [
                    $faker->word() => $faker->word(),
                    $faker->word() => $faker->word(),
                ],
        ];
    }

    protected static function getClass(): string
    {
        return Email::class;
    }
}
