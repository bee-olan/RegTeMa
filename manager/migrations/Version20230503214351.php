<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503214351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_childmatkas ADD otec_nomer_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.otec_nomer_id IS \'(DC2Type:adminka_otec_ras_linia_nomer_id)\'');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas ADD CONSTRAINT FK_96652E2EB212E6C5 FOREIGN KEY (otec_nomer_id) REFERENCES adminka_otec_ras_linia_nomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_96652E2EB212E6C5 ON admin_matkas_childmatkas (otec_nomer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE admin_matkas_childmatkas DROP CONSTRAINT FK_96652E2EB212E6C5');
        $this->addSql('DROP INDEX IDX_96652E2EB212E6C5');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas DROP otec_nomer_id');
    }
}
