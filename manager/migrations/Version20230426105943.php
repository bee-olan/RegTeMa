<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426105943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_otec_ras ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE adminka_otec_ras ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras.id IS \'(DC2Type:adminka_otec_ras_id)\'');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD oblet VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD matka_linia VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD matka_nomer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD otec_linia VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ADD otec_nomer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias DROP matka');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias DROP otec');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias DROP oblet');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ALTER rasa_id TYPE UUID');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ALTER rasa_id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linias.rasa_id IS \'(DC2Type:adminka_otec_ras_id)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ADD matka VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ADD otec VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ADD oblet VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ALTER rasa_id TYPE UUID');
        $this->addSql('ALTER TABLE adminka_otec_ras_linias ALTER rasa_id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras_linias.rasa_id IS \'(DC2Type:adminka_rasa_id)\'');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP oblet');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP matka_linia');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP matka_nomer');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP otec_linia');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers DROP otec_nomer');
        $this->addSql('ALTER TABLE adminka_otec_ras ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE adminka_otec_ras ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN adminka_otec_ras.id IS \'(DC2Type:adminka_rasa_id)\'');
    }
}
