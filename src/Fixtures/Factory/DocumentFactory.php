<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use function Safe\file_get_contents;
use App\Bridge\Faker\ExtendedGenerator;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use League\Flysystem\FilesystemOperator;
use Safe\DateTimeImmutable;
use Zenstruck\Foundry\ModelFactory;
use function Symfony\Component\String\u;

/**
 * @extends ModelFactory<Document>
 */
final class DocumentFactory extends ModelFactory
{
    /**
     * @see https://github.com/zenstruck/foundry#factories-as-services
     */
    public function __construct(
        private readonly FilesystemOperator $documentsStorage,
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    public function withGroup(Group $group): self
    {
        return $this->addState(['group' => $group]);
    }

    public function withCategory(Category $category): self
    {
        return $this->addState(['category' => $category]);
    }

    public function withFilename(string $filename): self
    {
        return $this->addState(['filename' => $filename]);
    }

    public static function getClass(): string
    {
        return Document::class;
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
            'group' => $faker->randomElement(Group::cases()),
            'category' => $faker->randomElement(Category::cases()),
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
            ->afterInstantiate(function (Document $document, array $attributes): void {
                // $object is the instantiated object
                // $attributes contains the attributes used to instantiate the object and any extras

                $this->documentsStorage->write($document->getFilename(), file_get_contents(sprintf('%s/src/Fixtures/Factory/files/test.pdf', $this->projectDir)));
            });
    }
}
