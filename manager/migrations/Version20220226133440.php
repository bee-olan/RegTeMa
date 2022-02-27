<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220226133440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paseka_rasas_rasas (id UUID NOT NULL, name VARCHAR(255) NOT NULL, psewdo VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN paseka_rasas_rasas.id IS \'(DC2Type:paseka_rasas_rasa_id)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE paseka_rasas_rasas');
    }
}
