<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Bridge\Faker\ExtendedGenerator;
use App\Domain\Enum\Type;
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

        $filename = u($faker->sha1)->truncate(20)->append('.pdf')->toString();

        $defaults = [
            'createdAt' => new DateTimeImmutable(),
            'type' => $faker->randomElement(Type::cases()),
            'content' => $faker->text(),
            'filename' => $filename,
            'user' => sprintf('%s %s', $faker->firstName(), $faker->lastName()),
        ];

        $this->createDocument($defaults['filename'], $defaults['content']);

        return $defaults;
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
