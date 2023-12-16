<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231216092717 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE emails (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sender VARCHAR(255) NOT NULL, receiver VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, body TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN emails.id IS \'(DC2Type:App\\Bridge\\Doctrine\\DBAL\\Types\\Type\\Identifier\\EmailIdType)\'');
        $this->addSql('COMMENT ON COLUMN emails.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
