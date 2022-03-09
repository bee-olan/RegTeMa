<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309073546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasas_rasa_linia_nomers (id UUID NOT NULL, linia_id UUID NOT NULL, name VARCHAR(255) NOT NULL, name_star VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort_nomer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7AE34327400E94F9 ON paseka_rasas_rasa_linia_nomers (linia_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_linia_nomers.id IS \'(DC2Type:paseka_rasas_rasa_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_linia_nomers.linia_id IS \'(DC2Type:paseka_rasas_rasa_linia_id)\'');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_linia_nomers ADD CONSTRAINT FK_7AE34327400E94F9 FOREIGN KEY (linia_id) REFERENCES paseka_rasas_rasa_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_rasas_rasa_linia_nomers');
    }
}
