<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250317094309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816B2B59251 FOREIGN KEY (code_postal_id) REFERENCES code_postal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_adresse');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_commercant');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_FD1E09064DE7DC5C');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_FD1E090683FA6DD0');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_FD1E09064DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_FD1E090683FA6DD0 FOREIGN KEY (commercant_id) REFERENCES commercant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A73F0036');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816B2B59251');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_FD1E090683FA6DD0');
        $this->addSql('ALTER TABLE commercant_adresse DROP FOREIGN KEY FK_FD1E09064DE7DC5C');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_adresse FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_commercant FOREIGN KEY (commercant_id) REFERENCES commercant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_FD1E090683FA6DD0 FOREIGN KEY (commercant_id) REFERENCES commercant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commercant_adresse ADD CONSTRAINT FK_FD1E09064DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
