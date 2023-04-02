<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402122640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_matkas_childmatkas_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin_matkas_childmatkas (id INT NOT NULL, plemmatka_id UUID NOT NULL, author_id UUID NOT NULL, parent_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, zakaz_date DATE DEFAULT NULL, plan_date DATE DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, type VARCHAR(16) NOT NULL, priority SMALLINT NOT NULL, status VARCHAR(16) NOT NULL, kol_child INT NOT NULL, goda_vixod INT NOT NULL, sezon_plem VARCHAR(255) NOT NULL, sezon_child VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96652E2E9D579D57 ON admin_matkas_childmatkas (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_96652E2EF675F31B ON admin_matkas_childmatkas (author_id)');
        $this->addSql('CREATE INDEX IDX_96652E2E727ACA70 ON admin_matkas_childmatkas (parent_id)');
        $this->addSql('CREATE INDEX IDX_96652E2EAA9E377A ON admin_matkas_childmatkas (date)');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.id IS \'(DC2Type:admin_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.plemmatka_id IS \'(DC2Type:admin_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.author_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.parent_id IS \'(DC2Type:admin_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.zakaz_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.plan_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.type IS \'(DC2Type:admin_matkas_childmatka_type)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas.status IS \'(DC2Type:admin_matkas_childmatka_status)\'');
        $this->addSql('CREATE TABLE admin_matkas_childmatkas_executors (childmatka_id INT NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(childmatka_id, uchastie_id))');
        $this->addSql('CREATE INDEX IDX_D86F8DDB713A01FB ON admin_matkas_childmatkas_executors (childmatka_id)');
        $this->addSql('CREATE INDEX IDX_D86F8DDB6931F8F9 ON admin_matkas_childmatkas_executors (uchastie_id)');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas_executors.childmatka_id IS \'(DC2Type:admin_matkas_childmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_childmatkas_executors.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas ADD CONSTRAINT FK_96652E2E9D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas ADD CONSTRAINT FK_96652E2EF675F31B FOREIGN KEY (author_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas ADD CONSTRAINT FK_96652E2E727ACA70 FOREIGN KEY (parent_id) REFERENCES admin_matkas_childmatkas (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas_executors ADD CONSTRAINT FK_D86F8DDB713A01FB FOREIGN KEY (childmatka_id) REFERENCES admin_matkas_childmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas_executors ADD CONSTRAINT FK_D86F8DDB6931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE admin_matkas_childmatkas DROP CONSTRAINT FK_96652E2E727ACA70');
        $this->addSql('ALTER TABLE admin_matkas_childmatkas_executors DROP CONSTRAINT FK_D86F8DDB713A01FB');
        $this->addSql('DROP SEQUENCE admin_matkas_childmatkas_seq CASCADE');
        $this->addSql('DROP TABLE admin_matkas_childmatkas');
        $this->addSql('DROP TABLE admin_matkas_childmatkas_executors');
    }
}
