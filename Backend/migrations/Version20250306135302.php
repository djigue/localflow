<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306135302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paniers_produits (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_7B1D2CABFB88E14F (utilisateur_id), INDEX IDX_7B1D2CABF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paniers_promotions (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, promotion_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_146AE4C7FB88E14F (utilisateur_id), INDEX IDX_146AE4C7139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paniers_services (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, service_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_B602124EFB88E14F (utilisateur_id), INDEX IDX_B602124EED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE paniers_produits ADD CONSTRAINT FK_7B1D2CABFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paniers_produits ADD CONSTRAINT FK_7B1D2CABF347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE paniers_promotions ADD CONSTRAINT FK_146AE4C7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paniers_promotions ADD CONSTRAINT FK_146AE4C7139DF194 FOREIGN KEY (promotion_id) REFERENCES promotions (id)');
        $this->addSql('ALTER TABLE paniers_services ADD CONSTRAINT FK_B602124EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paniers_services ADD CONSTRAINT FK_B602124EED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paniers_produits DROP FOREIGN KEY FK_7B1D2CABFB88E14F');
        $this->addSql('ALTER TABLE paniers_produits DROP FOREIGN KEY FK_7B1D2CABF347EFB');
        $this->addSql('ALTER TABLE paniers_promotions DROP FOREIGN KEY FK_146AE4C7FB88E14F');
        $this->addSql('ALTER TABLE paniers_promotions DROP FOREIGN KEY FK_146AE4C7139DF194');
        $this->addSql('ALTER TABLE paniers_services DROP FOREIGN KEY FK_B602124EFB88E14F');
        $this->addSql('ALTER TABLE paniers_services DROP FOREIGN KEY FK_B602124EED5CA9E6');
        $this->addSql('DROP TABLE paniers_produits');
        $this->addSql('DROP TABLE paniers_promotions');
        $this->addSql('DROP TABLE paniers_services');
    }
}
