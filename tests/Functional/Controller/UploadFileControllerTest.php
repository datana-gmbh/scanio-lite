<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Domain\Enum\Group;
use App\Fixtures\Factory\UserFactory;
use App\Tests\Functional\FunctionalTestCase;

final class UploadFileControllerTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function anUnauthenticatedUserWillRedirectToLoginPage(): void
    {
        $this->browser()
            ->interceptRedirects()
            ->visit('/upload/file')
            ->assertRedirected()
            ->assertRedirectedTo('/login');
    }

    /**
     * @test
     *
     * @dataProvider fixtureFiles
     *
     * @testdox An authenticated User can upload file: $fixtureFile
     */
    public function anAuthenticatedUserCanUploadFile(string $fixtureFile): void
    {
        $faker = self::faker();

        $user = UserFactory::createOne();

        $this->browser()
            ->login($user)
            ->visit('/upload/file')
            ->visit('/dashboard')
            ->assertSee($user->getEmail())
            ->visit('/upload/file')
            ->assertOn('/upload/file')
            ->assertSee('Datei Hochladen')
            ->fillField('upload_form[inbox_date]', $faker->date())
            ->selectFieldOptionByEnum('upload_form[group]', Group::Default)
            ->attachFile('upload_form[file]', self::fixtureFile($fixtureFile))
            ->click('Hochladen')
            ->assertOn('/dashboard')
            ->assertSee('Die Datei wurde hochgeladen und zur Weiterverarbeitung vorgemerkt.');
    }

    /**
     * @return \Generator<string[]>
     */
    public static function fixtureFiles(): iterable
    {
        yield ['blank.pdf'];
    }
}
