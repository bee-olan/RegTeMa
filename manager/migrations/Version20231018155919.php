<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018155919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_drevmatkas (id UUID NOT NULL, nomer_id UUID NOT NULL, mesto_id UUID NOT NULL, persona_id UUID NOT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, status VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3F53E1776033C160 ON admin_drevmatkas (nomer_id)');
        $this->addSql('CREATE INDEX IDX_3F53E1778CE3CB56 ON admin_drevmatkas (mesto_id)');
        $this->addSql('CREATE INDEX IDX_3F53E177F5F88DB9 ON admin_drevmatkas (persona_id)');
        $this->addSql('COMMENT ON COLUMN admin_drevmatkas.id IS \'(DC2Type:admin_drevmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_drevmatkas.nomer_id IS \'(DC2Type:dre_ras_rod_lini_wet_nomw_nom_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_drevmatkas.mesto_id IS \'(DC2Type:mesto_mestonomer_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_drevmatkas.persona_id IS \'(DC2Type:adminka_uchasties_persona_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_drevmatkas.status IS \'(DC2Type:admin_drevmatka_status)\'');
        $this->addSql('ALTER TABLE admin_drevmatkas ADD CONSTRAINT FK_3F53E1776033C160 FOREIGN KEY (nomer_id) REFERENCES dre_ras_rod_lini_wet_nomw_noms (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_drevmatkas ADD CONSTRAINT FK_3F53E1778CE3CB56 FOREIGN KEY (mesto_id) REFERENCES mesto_mestonomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_drevmatkas ADD CONSTRAINT FK_3F53E177F5F88DB9 FOREIGN KEY (persona_id) REFERENCES adminka_uchasties_personas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin_drevmatkas');
    }
}
