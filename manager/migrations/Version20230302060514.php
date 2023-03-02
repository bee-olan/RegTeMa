<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302060514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adminka_matkas_plemmatka_uchastniks (id UUID NOT NULL, plemmatka_id UUID NOT NULL, uchastie_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_693E38469D579D57 ON adminka_matkas_plemmatka_uchastniks (plemmatka_id)');
        $this->addSql('CREATE INDEX IDX_693E38466931F8F9 ON adminka_matkas_plemmatka_uchastniks (uchastie_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_693E38469D579D576931F8F9 ON adminka_matkas_plemmatka_uchastniks (plemmatka_id, uchastie_id)');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_plemmatka_uchastniks.plemmatka_id IS \'(DC2Type:admin_matkas_plemmatka_id)\'');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_plemmatka_uchastniks.uchastie_id IS \'(DC2Type:admin_uchasties_uchastie_id)\'');
        $this->addSql('CREATE TABLE adminka_matkas_plemmatka_uchastnik_departments (uchastnik_id UUID NOT NULL, department_id UUID NOT NULL, PRIMARY KEY(uchastnik_id, department_id))');
        $this->addSql('CREATE INDEX IDX_671B9F1D6E2164AC ON adminka_matkas_plemmatka_uchastnik_departments (uchastnik_id)');
        $this->addSql('CREATE INDEX IDX_671B9F1DAE80F5DF ON adminka_matkas_plemmatka_uchastnik_departments (department_id)');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_plemmatka_uchastnik_departments.department_id IS \'(DC2Type:admin_matkas_plemmatka_department_id)\'');
        $this->addSql('CREATE TABLE adminka_matkas_plemmatka_uchastnik_roles (uchastnik_id UUID NOT NULL, role_id UUID NOT NULL, PRIMARY KEY(uchastnik_id, role_id))');
        $this->addSql('CREATE INDEX IDX_BEB68E596E2164AC ON adminka_matkas_plemmatka_uchastnik_roles (uchastnik_id)');
        $this->addSql('CREATE INDEX IDX_BEB68E59D60322AC ON adminka_matkas_plemmatka_uchastnik_roles (role_id)');
        $this->addSql('COMMENT ON COLUMN adminka_matkas_plemmatka_uchastnik_roles.role_id IS \'(DC2Type:adminka_matkas_role_id)\'');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastniks ADD CONSTRAINT FK_693E38469D579D57 FOREIGN KEY (plemmatka_id) REFERENCES admin_matkas_plemmatkas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastniks ADD CONSTRAINT FK_693E38466931F8F9 FOREIGN KEY (uchastie_id) REFERENCES admin_uchasties_uchasties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_departments ADD CONSTRAINT FK_671B9F1D6E2164AC FOREIGN KEY (uchastnik_id) REFERENCES adminka_matkas_plemmatka_uchastniks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_departments ADD CONSTRAINT FK_671B9F1DAE80F5DF FOREIGN KEY (department_id) REFERENCES admin_matkas_plemmatka_departments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_roles ADD CONSTRAINT FK_BEB68E596E2164AC FOREIGN KEY (uchastnik_id) REFERENCES adminka_matkas_plemmatka_uchastniks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_roles ADD CONSTRAINT FK_BEB68E59D60322AC FOREIGN KEY (role_id) REFERENCES adminka_matkas_roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_departments DROP CONSTRAINT FK_671B9F1D6E2164AC');
        $this->addSql('ALTER TABLE adminka_matkas_plemmatka_uchastnik_roles DROP CONSTRAINT FK_BEB68E596E2164AC');
        $this->addSql('DROP TABLE adminka_matkas_plemmatka_uchastniks');
        $this->addSql('DROP TABLE adminka_matkas_plemmatka_uchastnik_departments');
        $this->addSql('DROP TABLE adminka_matkas_plemmatka_uchastnik_roles');
    }
}
