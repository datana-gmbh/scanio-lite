<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use App\Fixtures\Factory\UserFactory;
use App\Tests\Functional\FunctionalTestCase;
use function Symfony\Component\String\u;

final class LoginControllerTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function visit(): void
    {
        $this->browser()
            ->visit('/login')
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Anmeldung');
    }

    /**
     * @test
     */
    public function loginWithInvalidCredentials(): void
    {
        $faker = self::faker();

        $this->browser()
            ->loginAs(
                $faker->email(),
                $faker->password(8),
            )
            ->assertOn('/login')
            ->assertSeeIn('#login-form-error', 'Fehlerhafte Zugangsdaten.');
    }

    //    /**
    //     * @test
    //     */
    //    public function loginShouldBeCaseInsensitive(): void
    //    {
    //        $faker = self::faker();
    //
    //        $user = UserFactory::createOne([
    //            'email' => $faker->nonCanonicalEmail(),
    //        ]);
    //
    //        $this->browser()
    //            ->visit('/login')
    //            ->fillField('E-Mail', u($user->getEmail())->lower()->toString())
    //            ->fillField('Passwort', $user->getPassword())
    //            ->click('Weiter')
    //            ->assertSuccessful()
    //            ->assertOn('/user/dashboard');
    //    }

    /**
     * @test
     */
    public function userWillBeRedirectedToDashboard(): void
    {
        $user = UserFactory::create()
            ->create();

        $this->browser()
            ->visit('/login')
            ->fillField('Username', $user->getUsername())
            ->fillField('Passwort', $user->getPassword())
            ->click('Anmelden')
            ->assertSuccessful()
            ->assertOn('/dashboard');
    }
}
