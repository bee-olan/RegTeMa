<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226232351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_matkas_plemmatka_departments (id UUID NOT NULL, plemmatka_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C14B72909D579D57 ON admin_matkas_plemmatka_departments (plemmatka_id)');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatka_departments.id IS \'(DC2Type:admin_matkas_plemmatka_department_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatka_departments.plemmatka_id IS \'(DC2Type:admin_matkas_plemmatka_id)\'');
        $this->addSql('ALTER TABLE admin_matkas_plemmatka_departments ADD CONSTRAINT FK_C14B72909D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE admin_matkas_plemmatka_departments');
    }
}
