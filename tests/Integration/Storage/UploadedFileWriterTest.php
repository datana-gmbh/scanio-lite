<?php

declare(strict_types=1);

namespace App\Tests\Integration\Storage;

use App\Entity\User;
use App\Fixtures\Factory\UserFactory;
use App\Tests\Functional\FunctionalTestCase;
use App\Tests\Integration\IntegrationTestCase;
use function Symfony\Component\String\u;

final class UploadedFileWriterTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function write(): void
    {

    }

}
