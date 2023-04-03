<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403175637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adminka_matkas_childmatka_files (id UUID NOT NULL, childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FA0E00E3713A01FB ON adminka_matkas_childmatka_files (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_FA0E00E36931F8F9 ON adminka_matkas_childmatka_files (uchastie_id)');
        $this->addSql('CREATE INDEX IDX_FA0E00E3AA9E377A ON adminka_matkas_childmatka_files (date)');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_childmatka_files.id IS \'(DC2Type:adminka_matkas_childmatka_file_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_childmatka_files.childmatka_id IS \'(DC2Type:admin_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_childmatka_files.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_childmatka_files.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE adminka_matkas_childmatka_files ADD CONSTRAINT FK_FA0E00E3713A01FB FOREIGN KEY (childmatka_id) REFERENCES admin_matkas_childmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_childmatka_files ADD CONSTRAINT FK_FA0E00E36931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adminka_matkas_childmatka_files');
    }
}
