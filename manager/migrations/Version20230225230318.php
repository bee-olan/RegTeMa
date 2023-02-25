<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225230318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adminka_rasa_linias (id UUID NOT NULL, rasa_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_linia INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A4DE061981DBD4D8 ON adminka_rasa_linias (rasa_id)');
        $this->addSql('COMMENT ON COLUMN adminka_rasa_linias.id IS \'(DC2Type:adminka_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_rasa_linias.rasa_id IS \'(DC2Type:adminka_rasa_id)\'');
        $this->addSql('ALTER TABLE adminka_rasa_linias ADD CONSTRAINT FK_A4DE061981DBD4D8 FOREIGN KEY (rasa_id) REFERENCES adminka_rasas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE adminka_rasa_linias');
    }
}
