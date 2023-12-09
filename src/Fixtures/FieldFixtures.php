<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\FieldFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class FieldFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        FieldFactory::createOne([
            'name' => 'posteingangsdatum',
            'condition' => 'true',
        ]);

        FieldFactory::createOne([
            'name' => 'category',
            'condition' => 'isCategory("pending")',
        ]);

        FieldFactory::createOne([
            'name' => 'name_der_datei',
            'condition' => 'isCategory("other")',
        ]);
    }

    public function getOrder(): int
    {
        return 4;
    }
}
