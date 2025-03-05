<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214103412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, commerce_id INT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, inscription TINYINT(1) NOT NULL, nombre_participant INT DEFAULT NULL, alerte INT NOT NULL, complet TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E10AD4004DE7DC5C (adresse_id), INDEX IDX_E10AD400B09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4004DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400B09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4004DE7DC5C');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400B09114B7');
        $this->addSql('DROP TABLE evenements');
    }
}
