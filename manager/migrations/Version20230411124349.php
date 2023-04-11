<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411124349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_child_changes ADD set_kol_child INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_matkas_child_changes ADD set_goda_vixod INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_matkas_child_changes ADD set_sezon_plem VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_matkas_child_changes ADD set_sezon_child VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_matkas_child_changes DROP set_kol_child');
        $this->addSql('ALTER TABLE admin_matkas_child_changes DROP set_goda_vixod');
        $this->addSql('ALTER TABLE admin_matkas_child_changes DROP set_sezon_plem');
        $this->addSql('ALTER TABLE admin_matkas_child_changes DROP set_sezon_child');
    }
}
