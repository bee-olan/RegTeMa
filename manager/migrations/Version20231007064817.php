<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231007064817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms ADD zakazal_id UUID NOT NULL');
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms DROP zakazal');
        $this->addSql('COMMENT ON COLUMN dre_ras_rod_lini_wet_nomw_noms.zakazal_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms ADD CONSTRAINT FK_87A5F732FA237BF FOREIGN KEY (zakazal_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_87A5F732FA237BF ON dre_ras_rod_lini_wet_nomw_noms (zakazal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms DROP CONSTRAINT FK_87A5F732FA237BF');
        $this->addSql('DROP INDEX IDX_87A5F732FA237BF');
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms ADD zakazal VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dre_ras_rod_lini_wet_nomw_noms DROP zakazal_id');
    }
}
