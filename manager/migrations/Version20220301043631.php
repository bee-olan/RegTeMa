<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301043631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasas_rasa_pcheloships (id UUID NOT NULL, rasa_id UUID NOT NULL, pchelowod_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_78D143A781DBD4D8 ON paseka_rasas_rasa_pcheloships (rasa_id)');
        $this->addSql('CREATE INDEX IDX_78D143A798D61FA6 ON paseka_rasas_rasa_pcheloships (pchelowod_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_78D143A781DBD4D898D61FA6 ON paseka_rasas_rasa_pcheloships (rasa_id, pchelowod_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_pcheloships.rasa_id IS \'(DC2Type:paseka_rasas_rasa_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_pcheloships.pchelowod_id IS \'(DC2Type:paseka_pchelowods_pchelowod_id)\'');
        $this->addSql('CREATE TABLE paseka_rasas_rasa_pcheloship_linias (pcheloship_id UUID NOT NULL, linia_id UUID NOT NULL, PRIMARY KEY(pcheloship_id, linia_id))');
        $this->addSql('CREATE INDEX IDX_60325FDDDB331213 ON paseka_rasas_rasa_pcheloship_linias (pcheloship_id)');
        $this->addSql('CREATE INDEX IDX_60325FDD400E94F9 ON paseka_rasas_rasa_pcheloship_linias (linia_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_pcheloship_linias.linia_id IS \'(DC2Type:paseka_rasas_rasa_linia_id)\'');
        $this->addSql('CREATE TABLE paseka_rasas_rasa_pcheloship_kategors (pcheloship_id UUID NOT NULL, kategor_id UUID NOT NULL, PRIMARY KEY(pcheloship_id, kategor_id))');
        $this->addSql('CREATE INDEX IDX_345E3042DB331213 ON paseka_rasas_rasa_pcheloship_kategors (pcheloship_id)');
        $this->addSql('CREATE INDEX IDX_345E304226A45575 ON paseka_rasas_rasa_pcheloship_kategors (kategor_id)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasa_pcheloship_kategors.kategor_id IS \'(DC2Type:paseka_rasas_kategor_id)\'');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloships ADD CONSTRAINT FK_78D143A781DBD4D8 FOREIGN KEY (rasa_id) REFERENCES paseka_rasas_rasas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloships ADD CONSTRAINT FK_78D143A798D61FA6 FOREIGN KEY (pchelowod_id) REFERENCES paseka_pchelowods_pchelowods (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_linias ADD CONSTRAINT FK_60325FDDDB331213 FOREIGN KEY (pcheloship_id) REFERENCES paseka_rasas_rasa_pcheloships (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_linias ADD CONSTRAINT FK_60325FDD400E94F9 FOREIGN KEY (linia_id) REFERENCES paseka_rasas_rasa_linias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_kategors ADD CONSTRAINT FK_345E3042DB331213 FOREIGN KEY (pcheloship_id) REFERENCES paseka_rasas_rasa_pcheloships (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_kategors ADD CONSTRAINT FK_345E304226A45575 FOREIGN KEY (kategor_id) REFERENCES paseka_rasas_kategors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_linias DROP CONSTRAINT FK_60325FDDDB331213');
        $this->addSql('ALTER TABLE paseka_rasas_rasa_pcheloship_kategors DROP CONSTRAINT FK_345E3042DB331213');
        $this->addSql('DROP TABLE paseka_rasas_rasa_pcheloships');
        $this->addSql('DROP TABLE paseka_rasas_rasa_pcheloship_linias');
        $this->addSql('DROP TABLE paseka_rasas_rasa_pcheloship_kategors');
    }
}
