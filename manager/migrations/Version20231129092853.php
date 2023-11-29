<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129092853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dre_ras_linibr_vets (id UUID NOT NULL, linia_id UUID NOT NULL, nomer VARCHAR(255) NOT NULL, god VARCHAR(255) NOT NULL, sort_vet INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EDDF6CF3400E94F9 ON dre_ras_linibr_vets (linia_id)');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibr_vets.id IS \'(DC2Type:dre_ras_linibr_vet_id)\'');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibr_vets.linia_id IS \'(DC2Type:dre_ras_linibr_id)\'');
        $this->addSql('ALTER TABLE dre_ras_linibr_vets ADD CONSTRAINT FK_EDDF6CF3400E94F9 FOREIGN KEY (linia_id) REFERENCES dre_ras_linibrs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dre_ras_linibrs DROP CONSTRAINT fk_8774fa3b258a1f3');
        $this->addSql('DROP INDEX idx_8774fa3b258a1f3');
        $this->addSql('ALTER TABLE dre_ras_linibrs RENAME COLUMN vetka_id TO rodit_br_id');
        $this->addSql('ALTER TABLE dre_ras_linibrs ADD CONSTRAINT FK_8774FA37D357019 FOREIGN KEY (rodit_br_id) REFERENCES dre_ras_linibrs (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8774FA37D357019 ON dre_ras_linibrs (rodit_br_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_childdrevs_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE dre_ras_linibr_vets');
        $this->addSql('ALTER TABLE dre_ras_linibrs DROP CONSTRAINT FK_8774FA37D357019');
        $this->addSql('DROP INDEX IDX_8774FA37D357019');
        $this->addSql('ALTER TABLE dre_ras_linibrs RENAME COLUMN rodit_br_id TO vetka_id');
        $this->addSql('ALTER TABLE dre_ras_linibrs ADD CONSTRAINT fk_8774fa3b258a1f3 FOREIGN KEY (vetka_id) REFERENCES dre_ras_linibrs (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8774fa3b258a1f3 ON dre_ras_linibrs (vetka_id)');
    }
}
