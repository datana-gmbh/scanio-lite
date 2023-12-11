<?php

declare(strict_types=1);

namespace App\Bridge\Faker;

use App\Bridge\Faker\Provider\ArrayProvider;
use App\Bridge\Faker\Provider\EmailProvider;
use Faker\Factory;
use Faker\Generator;

/**
 * @method array  array()
 * @method array  arrayOrEmptyArray()
 * @method string emailOrNonCanonicalEmail()
 * @method string nonCanonicalEmail()
 */
final class ExtendedGenerator extends Generator
{
    public function __construct()
    {
        parent::__construct();

        // Get a default generator with default providers
        $generator = Factory::create('de_DE');

        $generator->seed(9001);

        // Add custom providers
        $generator->addProvider(new ArrayProvider($generator));
        $generator->addProvider(new EmailProvider($generator));

        // copy default and custom providers to this custom generator
        foreach ($generator->getProviders() as $provider) {
            $this->addProvider($provider);
        }
    }
}
