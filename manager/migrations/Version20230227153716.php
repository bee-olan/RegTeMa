<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227153716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adminka_matkas_roles (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_317610A45E237E06 ON adminka_matkas_roles (name)');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_roles.id IS \'(DC2Type:adminka_matkas_role_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_roles.permissions IS \'(DC2Type:adminka_matkas_role_permissions)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE adminka_matkas_roles');
    }
}
