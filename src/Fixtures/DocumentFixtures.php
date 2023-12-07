<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\DocumentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class DocumentFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        DocumentFactory::createMany(10);
    }

    public function getOrder(): int
    {
        return 2;
    }
}
