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
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeIn('p', 'Melden Sie sich jetzt in Ihrem Nutzerbereich an.');
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
            ->assertOn('/')
            ->assertSeeIn('#login-form-error', 'Invalid Credentials.');
    }

    /**
     * @test
     */
    public function loginShouldBeCaseInsensitive(): void
    {
        $faker = self::faker();

        /** @var User $user */
        $user = UserFactory::createOne([
            'email' => $faker->nonCanonicalEmail(),
        ])->object();

        $this->browser()
            ->visit('/login')
            ->loginAs(
                u($user->getEmail())->lower()->toString(),
                $user->getPassword(),
            )
            ->assertSuccessful()
            ->assertOn('/dashboard');
    }

    /**
     * @test
     */
    public function userWillBeRedirectedToDashboard(): void
    {
        $user = UserFactory::createOne();

        $this->browser()
            ->visit('/')
            ->login($user)
            ->assertSuccessful()
            ->assertOn('/dashboard');
    }
}
