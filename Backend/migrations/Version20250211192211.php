<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211192211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E66F3FE6B');
        $this->addSql('DROP INDEX IDX_DFD4704E66F3FE6B ON commerces');
        $this->addSql('ALTER TABLE commerces CHANGE commercant_id_id commercant_id INT NOT NULL');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E83FA6DD0 FOREIGN KEY (commercant_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_DFD4704E83FA6DD0 ON commerces (commercant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704E83FA6DD0');
        $this->addSql('DROP INDEX IDX_DFD4704E83FA6DD0 ON commerces');
        $this->addSql('ALTER TABLE commerces CHANGE commercant_id commercant_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704E66F3FE6B FOREIGN KEY (commercant_id_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DFD4704E66F3FE6B ON commerces (commercant_id_id)');
    }
}
