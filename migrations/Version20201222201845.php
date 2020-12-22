<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222201845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C515ED8D43');
        $this->addSql('DROP INDEX IDX_A2FE32C515ED8D43 ON user_test');
        $this->addSql('ALTER TABLE user_test DROP tour_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_test ADD tour_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C515ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('CREATE INDEX IDX_A2FE32C515ED8D43 ON user_test (tour_id)');
    }
}
