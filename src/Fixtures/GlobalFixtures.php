<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Story\GlobalStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class GlobalFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        GlobalStory::load();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
