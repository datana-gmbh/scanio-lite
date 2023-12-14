<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Fixtures\Factory\SourceFactory;
use App\Source\Value\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class SourceFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SourceFactory::createOne([
            'enabled' => true,
            'type' => Type::Dropbox,
            'token' => 'gOEi0xByodQAAAAAAABp1ylpqFG1oLVItQRWo-O3GGXi5csXTxRcnlmkMz1l1vG', // add 4 at the end to make it work
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
