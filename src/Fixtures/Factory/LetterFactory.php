<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Bridge\Faker\ExtendedGenerator;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Entity\Letter;
use League\Flysystem\FilesystemOperator;
use Safe\DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;
use function Symfony\Component\String\u;

/**
 * @extends ModelFactory<Letter>
 */
final class LetterFactory extends ModelFactory
{
    /**
     * @see https://github.com/zenstruck/foundry#factories-as-services
     */
    public function __construct(
        private readonly FilesystemOperator $documentsStorage,
    ) {
        parent::__construct();
    }

    public function withVenture(Venture $venture): self
    {
        return $this->addState(['venture' => $venture]);
    }

    public function withType(Type $type): self
    {
        return $this->addState(['type' => $type]);
    }

    public function withFilename(string $filename): self
    {
        return $this->addState(['filename' => $filename]);
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

        $filename = u($faker->sha1())->truncate(20)->append('.pdf')->toString();

        return [
            'createdAt' => $createdAt = new DateTimeImmutable(),
            'inboxDate' => clone $createdAt,
            'venture' => $faker->randomElement(Venture::cases()),
            'type' => $faker->randomElement(Type::cases()),
            'content' => $faker->text(),
            'filename' => $filename,
            'user' => sprintf('%s %s', $faker->firstName(), $faker->lastName()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Letter $letter, array $attributes): void {
                // $object is the instantiated object
                // $attributes contains the attributes used to instantiate the object and any extras

                $this->documentsStorage->write($letter->getFilename(), $letter->getContent() ?? '');
            });
    }
}
