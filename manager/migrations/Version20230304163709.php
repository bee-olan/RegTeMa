<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304163709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD nomer_id UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD mesto_id UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD persona_id UUID NOT NULL');
//        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP rasa_nom_id');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP mesto');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP persona');
//        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.nomer_id IS \'(DC2Type:adminka_rasa_linia_nomer_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.mesto_id IS \'(DC2Type:mesto_mestonomer_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_matkas_plemmatkas.persona_id IS \'(DC2Type:adminka_uchasties_persona_id)\'');
//        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD CONSTRAINT FK_9855C3E86033C160 FOREIGN KEY (nomer_id) REFERENCES adminka_rasa_linia_nomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD CONSTRAINT FK_9855C3E88CE3CB56 FOREIGN KEY (mesto_id) REFERENCES mesto_mestonomers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD CONSTRAINT FK_9855C3E8F5F88DB9 FOREIGN KEY (persona_id) REFERENCES adminka_uchasties_personas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
//        $this->addSql('CREATE INDEX IDX_9855C3E86033C160 ON admin_matkas_plemmatkas (nomer_id)');
        $this->addSql('CREATE INDEX IDX_9855C3E88CE3CB56 ON admin_matkas_plemmatkas (mesto_id)');
        $this->addSql('CREATE INDEX IDX_9855C3E8F5F88DB9 ON admin_matkas_plemmatkas (persona_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP CONSTRAINT FK_9855C3E86033C160');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP CONSTRAINT FK_9855C3E88CE3CB56');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP CONSTRAINT FK_9855C3E8F5F88DB9');
        $this->addSql('DROP INDEX IDX_9855C3E86033C160');
        $this->addSql('DROP INDEX IDX_9855C3E88CE3CB56');
        $this->addSql('DROP INDEX IDX_9855C3E8F5F88DB9');
//        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD rasa_nom_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD mesto VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas ADD persona INT NOT NULL');
//        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP nomer_id');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP mesto_id');
        $this->addSql('ALTER TABLE admin_matkas_plemmatkas DROP persona_id');
    }
}
