<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315081627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER DEFAULT NULL, gls_identifier VARCHAR(40) NOT NULL, gls_kind VARCHAR(16) NOT NULL, gls_name VARCHAR(16) NOT NULL, gls_surname VARCHAR(64) NOT NULL, gls_caste VARCHAR(16) DEFAULT NULL, gls_knowledge VARCHAR(16) DEFAULT NULL, gls_intelligence INTEGER DEFAULT NULL, gls_life INTEGER DEFAULT NULL, gls_image VARCHAR(128) DEFAULT NULL, gls_creation DATETIME NOT NULL, gls_modification DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3A29410E99E6F5DF ON characters (player_id)');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gls_identifier VARCHAR(40) NOT NULL, gls_firstname VARCHAR(50) NOT NULL, gls_lastname VARCHAR(50) NOT NULL, gls_email VARCHAR(255) NOT NULL, gls_mirian INTEGER DEFAULT NULL, gls_creation DATETIME NOT NULL, gls_modification DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE player');
    }
}
