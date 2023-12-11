<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231211143055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create bike sales table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bike_sale (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bike_id INTEGER NOT NULL, lovelace_price INTEGER NOT NULL, CONSTRAINT FK_F4FCC7E9D5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F4FCC7E9D5A4816F ON bike_sale (bike_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE bike_sale');
    }
}
