<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231110160628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create bike table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bike (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, asset_number VARCHAR(255) NOT NULL, score DOUBLE PRECISION NOT NULL, picture_url CLOB DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CBC37807EBD9049 ON bike (asset_number)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE bike');
    }
}
