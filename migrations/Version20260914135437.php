<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260914135437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_27BA704BA76ED395 ON history (user_id)');
        $this->addSql('ALTER TABLE track ADD history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A61E058452 FOREIGN KEY (history_id) REFERENCES history (id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61E058452 ON track (history_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('DROP INDEX IDX_27BA704BA76ED395 ON history');
        $this->addSql('ALTER TABLE history DROP user_id');
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A61E058452');
        $this->addSql('DROP INDEX IDX_D6E3F8A61E058452 ON track');
        $this->addSql('ALTER TABLE track DROP history_id');
    }
}
