<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211103052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commerces (id INT AUTO_INCREMENT NOT NULL, adresse_id_id INT NOT NULL, nom VARCHAR(100) NOT NULL, siret INT NOT NULL, telephone VARCHAR(20) DEFAULT NULL, secteur_activite VARCHAR(20) NOT NULL, fixe TINYINT(1) NOT NULL, slug VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, livraison TINYINT(1) NOT NULL, eco_responsable TINYINT(1) NOT NULL, statut VARCHAR(20) NOT NULL, lien VARCHAR(100) DEFAULT NULL, INDEX IDX_DFD4704E1004EF61 (adresse_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, commerce_id_id INT DEFAULT NULL, jour VARCHAR(20) DEFAULT NULL, ouverture TIME DEFAULT NULL, fermeture TIME DEFAULT NULL, INDEX IDX_39B7118FFF65992 (commerce_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E1004EF61 FOREIGN KEY (adresse_id_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FFF65992 FOREIGN KEY (commerce_id_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE utilisateur ADD commerce_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3FF65992 FOREIGN KEY (commerce_id_id) REFERENCES commerces (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3FF65992 ON utilisateur (commerce_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3FF65992');
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E1004EF61');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FFF65992');
        $this->addSql('DROP TABLE commerces');
        $this->addSql('DROP TABLE horaires');
        $this->addSql('DROP INDEX IDX_1D1C63B3FF65992 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP commerce_id_id');
    }
}
