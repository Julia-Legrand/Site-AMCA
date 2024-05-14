<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514075208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE other_club (id INT AUTO_INCREMENT NOT NULL, other_club_title VARCHAR(255) NOT NULL, other_club_picture VARCHAR(255) NOT NULL, other_club_content LONGTEXT NOT NULL, other_club_website VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE presentations DROP other_club_picture, DROP other_club_content, DROP other_club_website, DROP other_club_title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE other_club');
        $this->addSql('ALTER TABLE presentations ADD other_club_picture VARCHAR(255) DEFAULT NULL, ADD other_club_content LONGTEXT DEFAULT NULL, ADD other_club_website VARCHAR(255) DEFAULT NULL, ADD other_club_title VARCHAR(255) DEFAULT NULL');
    }
}
