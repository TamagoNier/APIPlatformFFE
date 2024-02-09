<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209154133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte ADD licence_id INT NOT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526026EF07C9 FOREIGN KEY (licence_id) REFERENCES licencie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFF6526026EF07C9 ON compte (licence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526026EF07C9');
        $this->addSql('DROP INDEX UNIQ_CFF6526026EF07C9 ON compte');
        $this->addSql('ALTER TABLE compte DROP licence_id');
    }
}
