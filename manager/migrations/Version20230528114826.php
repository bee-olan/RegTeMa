<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528114826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER oblet DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER title DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER matka_linia DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER matka_nomer DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER otec_linia DROP NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER otec_nomer DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER oblet SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER title SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER matka_linia SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER matka_nomer SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER otec_linia SET NOT NULL');
        $this->addSql('ALTER TABLE adminka_otec_ras_linia_nomers ALTER otec_nomer SET NOT NULL');
    }
}
