<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(8);
    }

    public function getOrder(): int
    {
        return 2;
    }
}
