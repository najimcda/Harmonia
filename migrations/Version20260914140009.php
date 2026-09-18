<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260914140009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite ADD track_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED95ED23C43 FOREIGN KEY (track_id) REFERENCES track (id)');
        $this->addSql('CREATE INDEX IDX_68C58ED95ED23C43 ON favorite (track_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED95ED23C43');
        $this->addSql('DROP INDEX IDX_68C58ED95ED23C43 ON favorite');
        $this->addSql('ALTER TABLE favorite DROP track_id');
    }
}
