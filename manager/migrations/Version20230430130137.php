<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430130137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_rasa_linia_nomers ADD status VARCHAR(16) NOT NULL');
        $this->addSql('COMMENT ON COLUMN adminka_rasa_linia_nomers.status IS \'(DC2Type:adminka_rasa_linia_nomer_status)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_rasa_linia_nomers DROP status');
    }
}
