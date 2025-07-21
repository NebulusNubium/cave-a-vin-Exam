<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721125329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cellar_items (cave_id INT NOT NULL, bouteilles_id INT NOT NULL, INDEX IDX_C94411F67F05B85 (cave_id), INDEX IDX_C94411F610E27C1B (bouteilles_id), PRIMARY KEY(cave_id, bouteilles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cellar_items ADD CONSTRAINT FK_C94411F67F05B85 FOREIGN KEY (cave_id) REFERENCES cave (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cellar_items ADD CONSTRAINT FK_C94411F610E27C1B FOREIGN KEY (bouteilles_id) REFERENCES bouteilles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cave_bouteilles DROP FOREIGN KEY FK_531B6C3B10E27C1B');
        $this->addSql('ALTER TABLE cave_bouteilles DROP FOREIGN KEY FK_531B6C3B7F05B85');
        $this->addSql('DROP TABLE cave_bouteilles');
        $this->addSql('ALTER TABLE cave DROP INDEX UNIQ_57F6D41A76ED395, ADD INDEX IDX_57F6D41A76ED395 (user_id)');
        $this->addSql('ALTER TABLE cave CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cave ADD CONSTRAINT FK_57F6D41A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cave_bouteilles (cave_id INT NOT NULL, bouteilles_id INT NOT NULL, INDEX IDX_531B6C3B10E27C1B (bouteilles_id), INDEX IDX_531B6C3B7F05B85 (cave_id), PRIMARY KEY(cave_id, bouteilles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cave_bouteilles ADD CONSTRAINT FK_531B6C3B10E27C1B FOREIGN KEY (bouteilles_id) REFERENCES bouteilles (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cave_bouteilles ADD CONSTRAINT FK_531B6C3B7F05B85 FOREIGN KEY (cave_id) REFERENCES cave (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cellar_items DROP FOREIGN KEY FK_C94411F67F05B85');
        $this->addSql('ALTER TABLE cellar_items DROP FOREIGN KEY FK_C94411F610E27C1B');
        $this->addSql('DROP TABLE cellar_items');
        $this->addSql('ALTER TABLE cave DROP INDEX IDX_57F6D41A76ED395, ADD UNIQUE INDEX UNIQ_57F6D41A76ED395 (user_id)');
        $this->addSql('ALTER TABLE cave DROP FOREIGN KEY FK_57F6D41A76ED395');
        $this->addSql('ALTER TABLE cave CHANGE user_id user_id INT DEFAULT NULL');
    }
}
