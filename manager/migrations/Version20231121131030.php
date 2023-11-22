<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121131030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_childdrevs_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin_childdrev_changes (id INT NOT NULL, childmatka_id INT NOT NULL, actor_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, set_plemmatka_id UUID DEFAULT NULL, set_name VARCHAR(255) DEFAULT NULL, set_content TEXT DEFAULT NULL, set_file_id UUID DEFAULT NULL, set_removed_file_id UUID DEFAULT NULL, set_type VARCHAR(16) DEFAULT NULL, set_status VARCHAR(255) DEFAULT NULL, set_priority SMALLINT DEFAULT NULL, set_kol_child INT DEFAULT NULL, set_goda_vixod INT DEFAULT NULL, set_parent_id INT DEFAULT NULL, set_removed_parent BOOLEAN DEFAULT NULL, set_plan DATE DEFAULT NULL, set_removed_plan BOOLEAN DEFAULT NULL, set_executor_id UUID DEFAULT NULL, set_revoked_executor_id UUID DEFAULT NULL, set_sezon_plem VARCHAR(255) DEFAULT NULL, set_sezon_child VARCHAR(255) DEFAULT NULL, set_urowni INT DEFAULT NULL, PRIMARY KEY(childmatka_id, id))');
        $this->addSql('CREATE INDEX IDX_4F48AB10713A01FB ON admin_childdrev_changes (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_4F48AB1010DAF24A ON admin_childdrev_changes (actor_id)');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.id IS \'(DC2Type:admin_childdrev_change_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.childmatka_id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.actor_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_plemmatka_id IS \'(DC2Type:admin_drevmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_file_id IS \'(DC2Type:admin_childdrev_file_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_removed_file_id IS \'(DC2Type:admin_childdrev_file_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_type IS \'(DC2Type:admin_childdrev_type)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_status IS \'(DC2Type:admin_childdrev_status)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_parent_id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_plan IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_executor_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_changes.set_revoked_executor_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE admin_childdrev_files (id UUID NOT NULL, childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6FD24CF1713A01FB ON admin_childdrev_files (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_6FD24CF16931F8F9 ON admin_childdrev_files (uchastie_id)');
        $this->addSql('CREATE INDEX IDX_6FD24CF1AA9E377A ON admin_childdrev_files (date)');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_files.id IS \'(DC2Type:admin_childdrev_file_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_files.childmatka_id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_files.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_files.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE admin_childdrevs (id INT NOT NULL, plemmatka_id UUID NOT NULL, author_id UUID NOT NULL, parent_id INT DEFAULT NULL, otec_nomer_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, zakaz_date DATE DEFAULT NULL, plan_date DATE DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, type VARCHAR(16) NOT NULL, priority SMALLINT NOT NULL, status VARCHAR(16) NOT NULL, kol_child INT NOT NULL, goda_vixod INT NOT NULL, sezon_plem VARCHAR(255) NOT NULL, sezon_child VARCHAR(255) DEFAULT NULL, urowni INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B5F9CCD69D579D57 ON admin_childdrevs (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_B5F9CCD6F675F31B ON admin_childdrevs (author_id)');
        $this->addSql('CREATE INDEX IDX_B5F9CCD6727ACA70 ON admin_childdrevs (parent_id)');
        $this->addSql('CREATE INDEX IDX_B5F9CCD6B212E6C5 ON admin_childdrevs (otec_nomer_id)');
        $this->addSql('CREATE INDEX IDX_B5F9CCD6AA9E377A ON admin_childdrevs (date)');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.plemmatka_id IS \'(DC2Type:admin_drevmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.author_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.parent_id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.otec_nomer_id IS \'(DC2Type:adminka_otec_ras_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.zakaz_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.plan_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.type IS \'(DC2Type:admin_childdrev_type)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrevs.status IS \'(DC2Type:admin_childdrev_status)\'');
        $this->addSql('CREATE TABLE admin_childdrev_executors (childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(childmatka_id, uchastie_id))');
        $this->addSql('CREATE INDEX IDX_3ED3DF14713A01FB ON admin_childdrev_executors (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_3ED3DF146931F8F9 ON admin_childdrev_executors (uchastie_id)');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_executors.childmatka_id IS \'(DC2Type:admin_childdrev_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_childdrev_executors.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE admin_childdrev_changes ADD CONSTRAINT FK_4F48AB10713A01FB FOREIGN KEY (childmatka_id) REFERENCES admin_childdrevs (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrev_changes ADD CONSTRAINT FK_4F48AB1010DAF24A FOREIGN KEY (actor_id) REFERENCES admin_uchasties_uchasties (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrev_files ADD CONSTRAINT FK_6FD24CF1713A01FB FOREIGN KEY (childmatka_id) REFERENCES admin_childdrevs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrev_files ADD CONSTRAINT FK_6FD24CF16931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrevs ADD CONSTRAINT FK_B5F9CCD69D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_drevmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrevs ADD CONSTRAINT FK_B5F9CCD6F675F31B FOREIGN KEY (author_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrevs ADD CONSTRAINT FK_B5F9CCD6727ACA70 FOREIGN KEY (parent_id) REFERENCES admin_childdrevs (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrevs ADD CONSTRAINT FK_B5F9CCD6B212E6C5 FOREIGN KEY (otec_nomer_id) REFERENCES adminka_otec_ras_linia_nomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrev_executors ADD CONSTRAINT FK_3ED3DF14713A01FB FOREIGN KEY (childmatka_id) REFERENCES admin_childdrevs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_childdrev_executors ADD CONSTRAINT FK_3ED3DF146931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_childdrev_changes DROP CONSTRAINT FK_4F48AB10713A01FB');
        $this->addSql('ALTER TABLE admin_childdrev_files DROP CONSTRAINT FK_6FD24CF1713A01FB');
        $this->addSql('ALTER TABLE admin_childdrevs DROP CONSTRAINT FK_B5F9CCD6727ACA70');
        $this->addSql('ALTER TABLE admin_childdrev_executors DROP CONSTRAINT FK_3ED3DF14713A01FB');
        $this->addSql('DROP SEQUENCE admin_childdrevs_seq CASCADE');
        $this->addSql('DROP TABLE admin_childdrev_changes');
        $this->addSql('DROP TABLE admin_childdrev_files');
        $this->addSql('DROP TABLE admin_childdrevs');
        $this->addSql('DROP TABLE admin_childdrev_executors');
    }
}
