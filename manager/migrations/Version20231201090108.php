<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201090108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dre_ras_linibr_vet_noms (id UUID NOT NULL, vetka_id UUID NOT NULL, nom_br VARCHAR(255) NOT NULL, god VARCHAR(255) NOT NULL, sort_nom INT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A95DE840B258A1F3 ON dre_ras_linibr_vet_noms (vetka_id)');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibr_vet_noms.id IS \'(DC2Type:dre_ras_linibr_vet_nom_id)\'');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibr_vet_noms.vetka_id IS \'(DC2Type:dre_ras_linibr_vet_id)\'');
        $this->addSql('COMMENT ON COLUMN dre_ras_linibr_vet_noms.status IS \'(DC2Type:dre_ras_linibr_vet_nom_status)\'');
        $this->addSql('ALTER TABLE dre_ras_linibr_vet_noms ADD CONSTRAINT FK_A95DE840B258A1F3 FOREIGN KEY (vetka_id) REFERENCES dre_ras_linibr_vets (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dre_ras_linibr_vet_noms');
    }
}
