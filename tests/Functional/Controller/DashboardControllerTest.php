<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Fixtures\Factory\UserFactory;
use App\Tests\Functional\FunctionalTestCase;

final class DashboardControllerTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function anUnauthenticatedUserWillRedirectToLoginPage(): void
    {
        $this->browser()
            ->interceptRedirects()
            ->visit('/dashboard')
            ->assertRedirected()
            ->assertRedirectedTo('/');
    }

    /**
     * @test
     */
    public function anAuthenticatedUserCanVisitPage(): void
    {
        $user = UserFactory::createOne();

        $this->browser()
            ->login($user)
            ->visit('/dashboard')
            ->assertOn('/dashboard')
            ->assertSee('Willkommen bei Scanio!');
    }
}
