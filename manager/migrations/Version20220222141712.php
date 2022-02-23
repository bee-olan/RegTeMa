<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222141712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matkis_u4astniks_u4astniks (id UUID NOT NULL, group_id UUID NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B7809C2CFE54D947 ON matkis_u4astniks_u4astniks (group_id)');
        $this->addSql('COMMENT ON COLUMN matkis_u4astniks_u4astniks.id IS \'(DC2Type:matkis_u4astniks_u4astnik_id)\'');
        $this->addSql('COMMENT ON COLUMN matkis_u4astniks_u4astniks.group_id IS \'(DC2Type:matkis_u4astniks_group_id)\'');
        $this->addSql('COMMENT ON COLUMN matkis_u4astniks_u4astniks.email IS \'(DC2Type:matkis_u4astniks_u4astnik_email)\'');
        $this->addSql('COMMENT ON COLUMN matkis_u4astniks_u4astniks.status IS \'(DC2Type:matkis_u4astniks_u4astnik_status)\'');
        $this->addSql('ALTER TABLE matkis_u4astniks_u4astniks ADD CONSTRAINT FK_B7809C2CFE54D947 FOREIGN KEY (group_id) REFERENCES matkis_u4astniks_groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE matkis_u4astniks_u4astniks');
    }
}
