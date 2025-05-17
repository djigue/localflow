<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250314221556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige les relations entre adresse, ville et commercant en tenant compte de l\'état actuel de la base.';
    }

    public function up(Schema $schema): void
    {
        // Modification des colonnes de la table adresse pour interdire les valeurs NULL
        $this->addSql('ALTER TABLE adresse CHANGE code_postal_id code_postal_id INT NOT NULL, CHANGE ville_id ville_id INT NOT NULL');

        // Suppression et ajout de la contrainte sur la table adresse
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A73F0036');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');

        // Rien à faire sur la table commercant, car adresse_id a déjà été retirée
    }

    public function down(Schema $schema): void
    {
        // Suppression de la contrainte entre adresse et ville
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A73F0036');

        // Restauration de la colonne et de la contrainte dans commercant
        $this->addSql('ALTER TABLE adresse CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE code_postal_id code_postal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commercant ADD COLUMN adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commercant ADD CONSTRAINT FK_ECB4268F4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_ECB4268F4DE7DC5C ON commercant (adresse_id)');
    }
}
