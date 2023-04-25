<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425173352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adminka_otec_ras (id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras.id IS \'(DC2Type:adminka_rasa_id)\'');
        $this->addSql('CREATE TABLE adminka_otec_ras_linia_nomers (id UUID NOT NULL, linia_id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_699EDA52400E94F9 ON adminka_otec_ras_linia_nomers (linia_id)');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linia_nomers.id IS \'(DC2Type:adminka_otec_ras_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linia_nomers.linia_id IS \'(DC2Type:adminka_otec_ras_linia_id)\'');
        $this->addSql('CREATE TABLE adminka_otec_ras_linias (id UUID NOT NULL, rasa_id UUID NOT NULL, name VARCHAR(255) NOT NULL, matka VARCHAR(255) NOT NULL, otec VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, oblet VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75155DD281DBD4D8 ON adminka_otec_ras_linias (rasa_id)');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linias.id IS \'(DC2Type:adminka_otec_ras_linia_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linias.rasa_id IS \'(DC2Type:adminka_rasa_id)\'');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD CONSTRAINT FK_699EDA52400E94F9 FOREIGN KEY (linia_id) REFERENCES adminka_otec_ras_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ADD CONSTRAINT FK_75155DD281DBD4D8 FOREIGN KEY (rasa_id) REFERENCES adminka_otec_ras (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_otec_ras_linias DROP CONSTRAINT FK_75155DD281DBD4D8');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP CONSTRAINT FK_699EDA52400E94F9');
        $this->addSql('DROP TABLE adminka_otec_ras');
        $this->addSql('DROP TABLE adminka_otec_ras_linia_nomers');
        $this->addSql('DROP TABLE adminka_otec_ras_linias');
    }
}
