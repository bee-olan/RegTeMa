<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220226062321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_pchelowods_pchelowods (id UUID NOT NULL, group_id UUID NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E1B98AAFE54D947 ON paseka_pchelowods_pchelowods (group_id)');
        $this->addSql('COMMENT ON COLUMN paseka_pchelowods_pchelowods.id IS \'(DC2Type:paseka_pchelowods_pchelowod_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_pchelowods_pchelowods.group_id IS \'(DC2Type:paseka_pchelowods_group_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_pchelowods_pchelowods.email IS \'(DC2Type:paseka_pchelowods_pchelowod_email)\'');
        $this->addSql('COMMENT ON COLUMN paseka_pchelowods_pchelowods.status IS \'(DC2Type:paseka_pchelowods_pchelowod_status)\'');
        $this->addSql('ALTER TABLE paseka_pchelowods_pchelowods ADD CONSTRAINT FK_7E1B98AAFE54D947 FOREIGN KEY (group_id) REFERENCES paseka_pchelowods_groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_pchelowods_pchelowods');
    }
}
