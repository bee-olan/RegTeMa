<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421133443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_rasa_linias ADD vetka_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN adminka_rasa_linias.vetka_id IS \'(DC2Type:adminka_rasa_linia_id)\'');
        $this->addSql('ALTER TABLE adminka_rasa_linias ADD CONSTRAINT FK_A4DE0619B258A1F3 FOREIGN KEY (vetka_id) REFERENCES adminka_rasa_linias (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A4DE0619B258A1F3 ON adminka_rasa_linias (vetka_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_rasa_linias DROP CONSTRAINT FK_A4DE0619B258A1F3');
        $this->addSql('DROP INDEX IDX_A4DE0619B258A1F3');
        $this->addSql('ALTER TABLE adminka_rasa_linias DROP vetka_id');
    }
}
