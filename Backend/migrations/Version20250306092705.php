<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306092705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, numero INT DEFAULT NULL, rue VARCHAR(255) NOT NULL, INDEX IDX_EF192552A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE codes_postaux (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commerces (id INT AUTO_INCREMENT NOT NULL, commercant_id INT NOT NULL, nom VARCHAR(50) NOT NULL, siret VARCHAR(14) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, secteur_activite VARCHAR(20) NOT NULL, fixe TINYINT(1) NOT NULL, slug VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, livraison TINYINT(1) NOT NULL, eco_responsable TINYINT(1) NOT NULL, statut VARCHAR(20) NOT NULL, lien VARCHAR(255) DEFAULT NULL, INDEX IDX_DFD4704E83FA6DD0 (commercant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commerces_adresses (commerces_id INT NOT NULL, adresses_id INT NOT NULL, INDEX IDX_C73DA09BB2C40A1E (commerces_id), INDEX IDX_C73DA09B85E14726 (adresses_id), PRIMARY KEY(commerces_id, adresses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, commerce_id INT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, inscription TINYINT(1) NOT NULL, nombre_participant INT DEFAULT NULL, alerte INT NOT NULL, complet TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E10AD4004DE7DC5C (adresse_id), INDEX IDX_E10AD400B09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, commerce_id INT NOT NULL, jour VARCHAR(10) NOT NULL, ouverture VARCHAR(10) NOT NULL, fermeture VARCHAR(10) NOT NULL, INDEX IDX_39B7118FB09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_commerces (id INT AUTO_INCREMENT NOT NULL, commerce_id INT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_7210DB75B09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_evenements (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_50ACF98FFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_produits (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_1D0EA2E6F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_promotions (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_5BBD1DBB139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_services (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_D0119C03ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, commerce_id INT NOT NULL, nom VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, quantite INT NOT NULL, alerte INT DEFAULT NULL, taille VARCHAR(10) DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, format_prix VARCHAR(10) NOT NULL, statut VARCHAR(20) NOT NULL, INDEX IDX_BE2DDF8CB09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, service_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, slug VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, reduction INT NOT NULL, format_reduction VARCHAR(5) NOT NULL, nouveau_prix DOUBLE PRECISION NOT NULL, INDEX IDX_EA1B3034F347EFB (produit_id), INDEX IDX_EA1B3034ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, commerce_id INT NOT NULL, nom VARCHAR(50) NOT NULL, slug VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, duree VARCHAR(50) DEFAULT NULL, reservation TINYINT(1) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_7332E169B09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_AC6A4CA29D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, civilite VARCHAR(20) DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, pseudo VARCHAR(20) DEFAULT NULL, date_naissance DATE NOT NULL, password VARCHAR(100) NOT NULL, email VARCHAR(20) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, role VARCHAR(20) NOT NULL, date_inscription DATETIME NOT NULL, ambassadeur TINYINT(1) NOT NULL, experience INT NOT NULL, INDEX IDX_1D1C63B34DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes (id INT AUTO_INCREMENT NOT NULL, cp_id_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_19209FD893907B72 (cp_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF192552A73F0036 FOREIGN KEY (ville_id) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E83FA6DD0 FOREIGN KEY (commercant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commerces_adresses ADD CONSTRAINT FK_C73DA09BB2C40A1E FOREIGN KEY (commerces_id) REFERENCES commerces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commerces_adresses ADD CONSTRAINT FK_C73DA09B85E14726 FOREIGN KEY (adresses_id) REFERENCES adresses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4004DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400B09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FB09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE images_commerces ADD CONSTRAINT FK_7210DB75B09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE images_evenements ADD CONSTRAINT FK_50ACF98FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenements (id)');
        $this->addSql('ALTER TABLE images_produits ADD CONSTRAINT FK_1D0EA2E6F347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE images_promotions ADD CONSTRAINT FK_5BBD1DBB139DF194 FOREIGN KEY (promotion_id) REFERENCES promotions (id)');
        $this->addSql('ALTER TABLE images_services ADD CONSTRAINT FK_D0119C03ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CB09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034F347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169B09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA29D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE villes ADD CONSTRAINT FK_19209FD893907B72 FOREIGN KEY (cp_id_id) REFERENCES codes_postaux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF192552A73F0036');
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E83FA6DD0');
        $this->addSql('ALTER TABLE commerces_adresses DROP FOREIGN KEY FK_C73DA09BB2C40A1E');
        $this->addSql('ALTER TABLE commerces_adresses DROP FOREIGN KEY FK_C73DA09B85E14726');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4004DE7DC5C');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400B09114B7');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FB09114B7');
        $this->addSql('ALTER TABLE images_commerces DROP FOREIGN KEY FK_7210DB75B09114B7');
        $this->addSql('ALTER TABLE images_evenements DROP FOREIGN KEY FK_50ACF98FFD02F13');
        $this->addSql('ALTER TABLE images_produits DROP FOREIGN KEY FK_1D0EA2E6F347EFB');
        $this->addSql('ALTER TABLE images_promotions DROP FOREIGN KEY FK_5BBD1DBB139DF194');
        $this->addSql('ALTER TABLE images_services DROP FOREIGN KEY FK_D0119C03ED5CA9E6');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CB09114B7');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034F347EFB');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034ED5CA9E6');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169B09114B7');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA29D86650F');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34DE7DC5C');
        $this->addSql('ALTER TABLE villes DROP FOREIGN KEY FK_19209FD893907B72');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE codes_postaux');
        $this->addSql('DROP TABLE commerces');
        $this->addSql('DROP TABLE commerces_adresses');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE horaires');
        $this->addSql('DROP TABLE images_commerces');
        $this->addSql('DROP TABLE images_evenements');
        $this->addSql('DROP TABLE images_produits');
        $this->addSql('DROP TABLE images_promotions');
        $this->addSql('DROP TABLE images_services');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE promotions');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE villes');
    }
}
