<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111181139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adm_drev_uchasdrevs (id UUID NOT NULL, plemmatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8459AE69D579D57 ON adm_drev_uchasdrevs (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_D8459AE66931F8F9 ON adm_drev_uchasdrevs (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8459AE69D579D576931F8F9 ON adm_drev_uchasdrevs (plemmatka_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN adm_drev_uchasdrevs.plemmatka_id IS \'(DC2Type:admin_drevmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN adm_drev_uchasdrevs.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE adm_drev_uchasdrev_sezondrevs (uchasdrev_id UUID NOT NULL, sezondrev_id UUID NOT NULL, PRIMARY KEY(uchasdrev_id, sezondrev_id))');
        $this->addSql('CREATE INDEX IDX_D9F12AF21A6858C1 ON adm_drev_uchasdrev_sezondrevs (uchasdrev_id)');
        $this->addSql('CREATE INDEX IDX_D9F12AF211C799DF ON adm_drev_uchasdrev_sezondrevs (sezondrev_id)');
        $this->addSql('COMMENT ON COLUMN adm_drev_uchasdrev_sezondrevs.sezondrev_id IS \'(DC2Type:adm_drev_sezondrev_id)\'');
        $this->addSql('ALTER TABLE adm_drev_uchasdrevs ADD CONSTRAINT FK_D8459AE69D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_drevmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adm_drev_uchasdrevs ADD CONSTRAINT FK_D8459AE66931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adm_drev_uchasdrev_sezondrevs ADD CONSTRAINT FK_D9F12AF21A6858C1 FOREIGN KEY (uchasdrev_id) REFERENCES adm_drev_uchasdrevs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adm_drev_uchasdrev_sezondrevs ADD CONSTRAINT FK_D9F12AF211C799DF FOREIGN KEY (sezondrev_id) REFERENCES adm_drev_sezondrevs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adm_drev_uchasdrev_sezondrevs DROP CONSTRAINT FK_D9F12AF21A6858C1');
        $this->addSql('DROP TABLE adm_drev_uchasdrevs');
        $this->addSql('DROP TABLE adm_drev_uchasdrev_sezondrevs');
    }
}
