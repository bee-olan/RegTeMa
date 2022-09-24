<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614064202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX idx_78d143a781dbd4d8 RENAME TO IDX_36B9266781DBD4D8');
        $this->addSql('ALTER INDEX idx_78d143a798d61fa6 RENAME TO IDX_36B9266798D61FA6');
        $this->addSql('ALTER INDEX uniq_78d143a781dbd4d898d61fa6 RENAME TO UNIQ_36B9266781DBD4D898D61FA6');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER INDEX uniq_36b9266781dbd4d898d61fa6 RENAME TO uniq_78d143a781dbd4d898d61fa6');
        $this->addSql('ALTER INDEX idx_36b9266781dbd4d8 RENAME TO idx_78d143a781dbd4d8');
        $this->addSql('ALTER INDEX idx_36b9266798d61fa6 RENAME TO idx_78d143a798d61fa6');
    }
}
