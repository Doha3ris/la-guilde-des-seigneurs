<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214124905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INT NOT NULL, identifier VARCHAR(40) NOT NULL, kind VARCHAR(16) NOT NULL, name VARCHAR(16) NOT NULL, surname VARCHAR(64) NOT NULL, caste VARCHAR(16) DEFAULT NULL, knowledge VARCHAR(16) DEFAULT NULL, intelligence INT DEFAULT NULL, life INT DEFAULT NULL, image VARCHAR(128) DEFAULT NULL, creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, identifier VARCHAR(40) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, mirian INT DEFAULT NULL, creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE player');
    }
}
