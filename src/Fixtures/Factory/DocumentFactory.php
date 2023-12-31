<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Bridge\Faker\ExtendedGenerator;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Webmozart\Assert\Assert;
use Zenstruck\Foundry\ModelFactory;
use function Safe\file_get_contents;
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
        #[Autowire('%kernel.project_dir%')]
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
            'createdAt' => $faker->dateTimeBetween('-1 year', '-1 day'),
            'group' => $faker->randomElement(Group::cases()),
            'category' => $faker->randomElement(Category::cases()),
            'content' => $faker->text(),
            'filename' => $filename,
            'user' => sprintf('%s %s', $faker->firstName(), $faker->lastName()),
            'originalFilename' => $faker->boolean(20) ? null : $filename,
            'source' => 'local:/foo',
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

                if ($document->getCategory()->equals(Category::Pending)) {
                    $document->setInboxDate(null);
                    $document->setUser(null);
                }

                $fixtureFilepath = sprintf(
                    '%s/src/Fixtures/Resources/files/invoice%s.pdf',
                    $this->projectDir,
                    self::faker()->numberBetween(1, 4),
                );
                Assert::fileExists($fixtureFilepath);

                $this->documentsStorage->write(
                    $document->getFilename(),
                    file_get_contents($fixtureFilepath),
                );
            });
    }
}
