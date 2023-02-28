<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228033258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_mute (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, mute_id INT NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6383F95A76ED395 (user_id), INDEX IDX_B6383F95B5483335 (mute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_mute ADD CONSTRAINT FK_B6383F95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_mute ADD CONSTRAINT FK_B6383F95B5483335 FOREIGN KEY (mute_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_mute DROP FOREIGN KEY FK_B6383F95A76ED395');
        $this->addSql('ALTER TABLE user_mute DROP FOREIGN KEY FK_B6383F95B5483335');
        $this->addSql('DROP TABLE user_mute');
    }
}
