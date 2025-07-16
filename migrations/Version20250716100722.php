<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250716100722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX name ON countries');
        $this->addSql('DROP INDEX name ON regions');
        $this->addSql('ALTER TABLE user ADD mail VARCHAR(255) NOT NULL, ADD birth DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX name ON countries (name)');
        $this->addSql('CREATE UNIQUE INDEX name ON regions (name)');
        $this->addSql('ALTER TABLE `user` DROP mail, DROP birth');
    }
}
