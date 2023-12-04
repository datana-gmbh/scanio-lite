<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Bridge\Faker\ExtendedGenerator;
use App\Domain\Enum\Type;
use App\Entity\Letter;
use Safe\DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Letter>
 */
final class LetterFactory extends ModelFactory
{
    /**
     * @see https://github.com/zenstruck/foundry#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function withType(Type $type): self
    {
        return $this->addState(['type' => $type]);
    }

    public static function getClass(): string
    {
        return Letter::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        /** @var ExtendedGenerator $faker */
        $faker = self::faker();

        return [
            'createdAt' => new DateTimeImmutable(),
            'type' => $faker->randomElement(Type::cases()),
            'content' => $faker->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
    }
}
