<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304153500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD kategoria_id UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD rasa_nom_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD mesto VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD persona INT NOT NULL');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.kategoria_id IS \'(DC2Type:admin_matkas_kategoria_id)\'');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD CONSTRAINT FK_9855C3E8359B0684 FOREIGN KEY (kategoria_id) REFERENCES admin_matkas_kategorias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9855C3E8359B0684 ON admin_matkas_plemmatkas (kategoria_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP CONSTRAINT FK_9855C3E8359B0684');
        $this->addSql('DROP INDEX IDX_9855C3E8359B0684');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP kategoria_id');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP rasa_nom_id');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP mesto');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP persona');
    }
}
