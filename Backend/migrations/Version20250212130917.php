<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212130917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commerces (id INT AUTO_INCREMENT NOT NULL, commercant_id INT NOT NULL, nom VARCHAR(50) NOT NULL, siret INT NOT NULL, telephone VARCHAR(20) DEFAULT NULL, secteur_activite VARCHAR(20) NOT NULL, fixe TINYINT(1) NOT NULL, slug VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, livraison TINYINT(1) NOT NULL, eco_responsable TINYINT(1) NOT NULL, statut VARCHAR(20) NOT NULL, lien VARCHAR(255) DEFAULT NULL, INDEX IDX_DFD4704E83FA6DD0 (commercant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commerces_adresses (commerces_id INT NOT NULL, adresses_id INT NOT NULL, INDEX IDX_C73DA09BB2C40A1E (commerces_id), INDEX IDX_C73DA09B85E14726 (adresses_id), PRIMARY KEY(commerces_id, adresses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, commerce_id INT NOT NULL, jour VARCHAR(10) NOT NULL, ouverture VARCHAR(10) NOT NULL, fermeture VARCHAR(10) NOT NULL, INDEX IDX_39B7118FB09114B7 (commerce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E83FA6DD0 FOREIGN KEY (commercant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commerces_adresses ADD CONSTRAINT FK_C73DA09BB2C40A1E FOREIGN KEY (commerces_id) REFERENCES commerces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commerces_adresses ADD CONSTRAINT FK_C73DA09B85E14726 FOREIGN KEY (adresses_id) REFERENCES adresses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118FB09114B7 FOREIGN KEY (commerce_id) REFERENCES commerces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E83FA6DD0');
        $this->addSql('ALTER TABLE commerces_adresses DROP FOREIGN KEY FK_C73DA09BB2C40A1E');
        $this->addSql('ALTER TABLE commerces_adresses DROP FOREIGN KEY FK_C73DA09B85E14726');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118FB09114B7');
        $this->addSql('DROP TABLE commerces');
        $this->addSql('DROP TABLE commerces_adresses');
        $this->addSql('DROP TABLE horaires');
    }
}
