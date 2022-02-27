<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227110026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasas_rasa_linias (id UUID NOT NULL, rasa_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, sort_linia INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55FAD55C81DBD4D8 ON paseka_rasas_rasa_linias (rasa_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_linias.id IS \'(DC2Type:paseka_rasas_rasa_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_linias.rasa_id IS \'(DC2Type:paseka_rasas_rasa_id)\'');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_linias ADD CONSTRAINT FK_55FAD55C81DBD4D8 FOREIGN KEY (rasa_id) REFERENCES paseka_rasas_rasas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_rasas_rasa_linias');
    }
}
