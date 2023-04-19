<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419154509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_mattest_plemtests (id INT NOT NULL, name VARCHAR(255) NOT NULL, star_linia VARCHAR(255) NOT NULL, star_nomer VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, goda_vixod INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN admin_mattest_plemtests.id IS \'(DC2Type:admin_mattest_plemtest_id)\'');
        $this->addSql('COMMENT ON COLUMN admin_mattest_plemtests.status IS \'(DC2Type:admin_mattest_plemtest_status)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin_mattest_plemtests');
    }
}
