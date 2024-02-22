<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\EmailFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class EmailFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        EmailFactory::createMany(10);
    }

    public function getOrder(): int
    {
        return 5;
    }
}
