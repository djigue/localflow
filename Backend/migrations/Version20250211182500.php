<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211182500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces ADD commerçant_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commerces ADD CONSTRAINT FK_DFD4704EA1AEF2D6 FOREIGN KEY (commerçant_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_DFD4704EA1AEF2D6 ON commerces (commerçant_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commerces DROP FOREIGN KEY FK_DFD4704EA1AEF2D6');
        $this->addSql('DROP INDEX IDX_DFD4704EA1AEF2D6 ON commerces');
        $this->addSql('ALTER TABLE commerces DROP commerçant_id_id');
    }
}
