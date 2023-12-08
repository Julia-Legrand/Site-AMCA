<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208143834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts ADD themes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA94F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFA94F4A9D2 ON posts (themes_id)');
        $this->addSql('ALTER TABLE themes ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE themes ADD CONSTRAINT FK_154232DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_154232DEA76ED395 ON themes (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA94F4A9D2');
        $this->addSql('DROP INDEX IDX_885DBAFA94F4A9D2 ON posts');
        $this->addSql('ALTER TABLE posts DROP themes_id');
        $this->addSql('ALTER TABLE themes DROP FOREIGN KEY FK_154232DEA76ED395');
        $this->addSql('DROP INDEX IDX_154232DEA76ED395 ON themes');
        $this->addSql('ALTER TABLE themes DROP user_id');
    }
}
