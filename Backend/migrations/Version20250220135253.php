<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220135253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images_promotions (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_5BBD1DBB139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, service_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, slug VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, reduction INT NOT NULL, format_reduction VARCHAR(5) NOT NULL, nouveau_prix DOUBLE PRECISION NOT NULL, INDEX IDX_EA1B3034F347EFB (produit_id), INDEX IDX_EA1B3034ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images_promotions ADD CONSTRAINT FK_5BBD1DBB139DF194 FOREIGN KEY (promotion_id) REFERENCES promotions (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034F347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_promotions DROP FOREIGN KEY FK_5BBD1DBB139DF194');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034F347EFB');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034ED5CA9E6');
        $this->addSql('DROP TABLE images_promotions');
        $this->addSql('DROP TABLE promotions');
    }
}
