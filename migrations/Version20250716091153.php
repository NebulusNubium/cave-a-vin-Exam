<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250716091153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, region VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bouteilles ADD region_id INT NOT NULL, ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CC98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CCF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_6475D7CC98260155 ON bouteilles (region_id)');
        $this->addSql('CREATE INDEX IDX_6475D7CCF92F3E70 ON bouteilles (country_id)');
        $this->addSql('ALTER TABLE countries DROP region');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CC98260155');
        $this->addSql('DROP TABLE regions');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCF92F3E70');
        $this->addSql('DROP INDEX IDX_6475D7CC98260155 ON bouteilles');
        $this->addSql('DROP INDEX IDX_6475D7CCF92F3E70 ON bouteilles');
        $this->addSql('ALTER TABLE bouteilles DROP region_id, DROP country_id');
        $this->addSql('ALTER TABLE countries ADD region VARCHAR(255) NOT NULL');
    }
}
