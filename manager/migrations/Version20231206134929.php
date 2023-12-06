<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206134929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD nomer_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.nomer_id IS \'(DC2Type:dre_ras_linibr_vet_nom_id)\'');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD CONSTRAINT FK_9855C3E86033C160 FOREIGN KEY (nomer_id) REFERENCES dre_ras_linibr_vet_noms (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9855C3E86033C160 ON admin_matkas_plemmatkas (nomer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP CONSTRAINT FK_9855C3E86033C160');
        $this->addSql('DROP INDEX IDX_9855C3E86033C160');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP nomer_id');
    }
}
