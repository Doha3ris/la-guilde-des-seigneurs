<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228121949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3A29410E99E6F5DF ON characters (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE characters DROP CONSTRAINT FK_3A29410E99E6F5DF');
        $this->addSql('DROP INDEX IDX_3A29410E99E6F5DF');
        $this->addSql('ALTER TABLE characters DROP player_id');
    }
}
