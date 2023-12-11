<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211140132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_pictures ADD previous_trips_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip_pictures ADD CONSTRAINT FK_272D1CD01F873408 FOREIGN KEY (previous_trips_id) REFERENCES previous_trips (id)');
        $this->addSql('CREATE INDEX IDX_272D1CD01F873408 ON trip_pictures (previous_trips_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_pictures DROP FOREIGN KEY FK_272D1CD01F873408');
        $this->addSql('DROP INDEX IDX_272D1CD01F873408 ON trip_pictures');
        $this->addSql('ALTER TABLE trip_pictures DROP previous_trips_id');
    }
}
