<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222201358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_test ADD test_id INT NOT NULL, ADD result_json LONGTEXT DEFAULT NULL, ADD result_saved_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C51E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_A2FE32C51E5D0459 ON user_test (test_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C51E5D0459');
        $this->addSql('DROP INDEX IDX_A2FE32C51E5D0459 ON user_test');
        $this->addSql('ALTER TABLE user_test DROP test_id, DROP result_json, DROP result_saved_at');
    }
}
