<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220145444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesto_okrug_oblast_raions DROP shir_dolg');
        $this->addSql('ALTER TABLE mesto_okrug_oblasts DROP shir_dolg');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesto_okrug_oblasts ADD shir_dolg VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mesto_okrug_oblast_raions ADD shir_dolg VARCHAR(255) NOT NULL');
    }
}