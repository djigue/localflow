<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211185029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704EA1AEF2D6');
        $this->addSql('DROP INDEX IDX_DFD4704EA1AEF2D6 ON commerces');
        $this->addSql('ALTER TABLE commerces CHANGE commerçant_id_id commercant_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E66F3FE6B FOREIGN KEY (commercant_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_DFD4704E66F3FE6B ON commerces (commercant_id_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3FF65992');
        $this->addSql('DROP INDEX IDX_1D1C63B3FF65992 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP commerce_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E66F3FE6B');
        $this->addSql('DROP INDEX IDX_DFD4704E66F3FE6B ON commerces');
        $this->addSql('ALTER TABLE commerces CHANGE commercant_id_id commerçant_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704EA1AEF2D6 FOREIGN KEY (commerçant_id_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DFD4704EA1AEF2D6 ON commerces (commerçant_id_id)');
        $this->addSql('ALTER TABLE utilisateur ADD commerce_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3FF65992 FOREIGN KEY (commerce_id_id) REFERENCES commerces (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1D1C63B3FF65992 ON utilisateur (commerce_id_id)');
    }
}
