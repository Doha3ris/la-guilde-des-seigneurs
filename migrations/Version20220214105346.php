<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214105346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifier VARCHAR(40) NOT NULL, kind VARCHAR(16) NOT NULL, name VARCHAR(16) NOT NULL, surname VARCHAR(64) NOT NULL, caste VARCHAR(16) DEFAULT NULL, knowledge VARCHAR(16) DEFAULT NULL, intelligence INTEGER DEFAULT NULL, life INTEGER DEFAULT NULL, image VARCHAR(128) DEFAULT NULL, creation DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE characters');
    }
}
