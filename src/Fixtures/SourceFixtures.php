<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\SourceFactory;
use App\Source\Value\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class SourceFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(
        #[Autowire('%env(DROPBOX_ACCESS_TOKEN)%')]
        private string $dropboxAccessToken,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        SourceFactory::createOne([
            'enabled' => true,
            'type' => Type::Dropbox,
            'token' => $this->dropboxAccessToken,
            'path' => '/scanbot',
            'recursiveImport' => true,
            'deleteAfterImport' => false,
        ]);
    }

    public function getOrder(): int
    {
        return 4;
    }
}
