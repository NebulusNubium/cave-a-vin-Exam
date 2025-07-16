<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250716081506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bouteilles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, grapes VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bouteilles_user (bouteilles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_147B26B010E27C1B (bouteilles_id), INDEX IDX_147B26B0A76ED395 (user_id), PRIMARY KEY(bouteilles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cave (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cave_bouteilles (cave_id INT NOT NULL, bouteilles_id INT NOT NULL, INDEX IDX_531B6C3B7F05B85 (cave_id), INDEX IDX_531B6C3B10E27C1B (bouteilles_id), PRIMARY KEY(cave_id, bouteilles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, caves_id INT DEFAULT NULL, bouteille_id INT DEFAULT NULL, stock INT NOT NULL, INDEX IDX_B12D4A367AA43AD1 (caves_id), INDEX IDX_B12D4A36F1966394 (bouteille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bouteilles_user ADD CONSTRAINT FK_147B26B010E27C1B FOREIGN KEY (bouteilles_id) REFERENCES bouteilles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bouteilles_user ADD CONSTRAINT FK_147B26B0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cave_bouteilles ADD CONSTRAINT FK_531B6C3B7F05B85 FOREIGN KEY (cave_id) REFERENCES cave (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cave_bouteilles ADD CONSTRAINT FK_531B6C3B10E27C1B FOREIGN KEY (bouteilles_id) REFERENCES bouteilles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A367AA43AD1 FOREIGN KEY (caves_id) REFERENCES cave (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36F1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles_user DROP FOREIGN KEY FK_147B26B010E27C1B');
        $this->addSql('ALTER TABLE bouteilles_user DROP FOREIGN KEY FK_147B26B0A76ED395');
        $this->addSql('ALTER TABLE cave_bouteilles DROP FOREIGN KEY FK_531B6C3B7F05B85');
        $this->addSql('ALTER TABLE cave_bouteilles DROP FOREIGN KEY FK_531B6C3B10E27C1B');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A367AA43AD1');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36F1966394');
        $this->addSql('DROP TABLE bouteilles');
        $this->addSql('DROP TABLE bouteilles_user');
        $this->addSql('DROP TABLE cave');
        $this->addSql('DROP TABLE cave_bouteilles');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
