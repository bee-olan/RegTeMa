<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227170419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasas_kategors (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A7568605E237E06 ON paseka_rasas_kategors (name)');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_kategors.id IS \'(DC2Type:paseka_rasas_kategor_id)\'');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_kategors.permissions IS \'(DC2Type:paseka_rasas_kategor_permissions)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    
        $this->addSql('DROP TABLE paseka_rasas_kategors');
    }
}
