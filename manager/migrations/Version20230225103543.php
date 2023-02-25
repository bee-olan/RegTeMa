<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225103543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_matkas_plemmatkas (id UUID NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, status VARCHAR(16) NOT NULL, goda_vixod INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.id IS \'(DC2Type:admin_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.status IS \'(DC2Type:admin_matkas_plemmatka_status)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE admin_matkas_plemmatkas');
    }
}
