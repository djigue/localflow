<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212112950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E1004EF61');
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E83FA6DD0');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FFF65992');
        $this->addSql('DROP TABLE commerces');
        $this->addSql('DROP TABLE horaires');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commerces (id INT AUTO_INCREMENT NOT NULL, adresse_id_id INT NOT NULL, commercant_id INT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, siret INT NOT NULL, telephone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, secteur_activite VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fixe TINYINT(1) NOT NULL, slug VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, livraison TINYINT(1) NOT NULL, eco_responsable TINYINT(1) NOT NULL, statut VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lien VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_DFD4704E1004EF61 (adresse_id_id), INDEX IDX_DFD4704E83FA6DD0 (commercant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, commerce_id_id INT DEFAULT NULL, jour VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ouverture VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, fermeture VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_39B7118FFF65992 (commerce_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E1004EF61 FOREIGN KEY (adresse_id_id) REFERENCES adresses (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E83FA6DD0 FOREIGN KEY (commercant_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FFF65992 FOREIGN KEY (commerce_id_id) REFERENCES commerces (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
