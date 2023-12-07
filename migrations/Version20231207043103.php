<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231207043103 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE documents (id UUID NOT NULL, content TEXT DEFAULT NULL, "group" VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, data TEXT NOT NULL, "user" TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, inbox_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, exported_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN documents.id IS \'(DC2Type:App\\Bridge\\Doctrine\\DBAL\\Types\\Type\\Identifier\\DocumentIdType)\'');
        $this->addSql('COMMENT ON COLUMN documents.data IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN documents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN documents.inbox_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN documents.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN documents.finished_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN documents.exported_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
