<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240222083332 extends AbstractMigration
{
    public function up(Schema $schema): void
    {

    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
