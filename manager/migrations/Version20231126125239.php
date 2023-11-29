<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126125239 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dre_ras_linibrs (id UUID NOT NULL, rasa_id UUID NOT NULL, vetka_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, sort_lini_br INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8774FA381DBD4D8 ON dre_ras_linibrs (rasa_id)');
        $this->addSql('CREATE INDEX IDX_8774FA3B258A1F3 ON dre_ras_linibrs (vetka_id)');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibrs.id IS \'(DC2Type:dre_ras_linibr_id)\'');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibrs.rasa_id IS \'(DC2Type:dre_ras_id)\'');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibrs.vetka_id IS \'(DC2Type:dre_ras_linibr_id)\'');
        $this->addSql('ALTER TABLE dre_ras_linibrs ADD CONSTRAINT FK_8774FA381DBD4D8 FOREIGN KEY (rasa_id) REFERENCES dre_rass (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dre_ras_linibrs ADD CONSTRAINT FK_8774FA3B258A1F3 FOREIGN KEY (vetka_id) REFERENCES dre_ras_linibrs (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dre_ras_linibrs DROP CONSTRAINT FK_8774FA3B258A1F3');
        $this->addSql('CREATE SEQUENCE admin_childdrevs_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE dre_ras_linibrs');
    }
}
