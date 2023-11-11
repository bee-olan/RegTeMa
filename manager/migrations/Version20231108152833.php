<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108152833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adm_drev_sezondrevs (id UUID NOT NULL, plemmatka_id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_77A8CF659D579D57 ON adm_drev_sezondrevs (plemmatka_id)');
        $this->addSql('COMMENT ON COLUMN adm_drev_sezondrevs.id IS \'(DC2Type:adm_drev_sezondrev_id)\'');
        $this->addSql('COMMENT ON COLUMN adm_drev_sezondrevs.plemmatka_id IS \'(DC2Type:admin_drevmatka_id)\'');
        $this->addSql('ALTER TABLE adm_drev_sezondrevs ADD CONSTRAINT FK_77A8CF659D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_drevmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adm_drev_sezondrevs');
    }
}
