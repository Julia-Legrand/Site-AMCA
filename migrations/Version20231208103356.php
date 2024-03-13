<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208103356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE future_trips_user (future_trips_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_42EB6D4C465AF6EC (future_trips_id), INDEX IDX_42EB6D4CA76ED395 (user_id), PRIMARY KEY(future_trips_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE future_trips_user ADD CONSTRAINT FK_42EB6D4C465AF6EC FOREIGN KEY (future_trips_id) REFERENCES future_trips (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE future_trips_user ADD CONSTRAINT FK_42EB6D4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE future_trips_user DROP FOREIGN KEY FK_42EB6D4C465AF6EC');
        $this->addSql('ALTER TABLE future_trips_user DROP FOREIGN KEY FK_42EB6D4CA76ED395');
        $this->addSql('DROP TABLE future_trips_user');
    }
}
