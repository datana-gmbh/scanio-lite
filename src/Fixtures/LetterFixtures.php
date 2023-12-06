<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\LetterFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class LetterFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        LetterFactory::createMany(10);
    }

    public function getOrder(): int
    {
        return 2;
    }
}
