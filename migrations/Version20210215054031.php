<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215054031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` RENAME INDEX idx_5ddb2fb81e27f6bf TO IDX_5A8600B01E27F6BF');
        $this->addSql('ALTER TABLE question CHANGE text_type text_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_292708c63b69a9af TO IDX_B6F7494E3B69A9AF');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` RENAME INDEX idx_5a8600b01e27f6bf TO IDX_5DDB2FB81E27F6BF');
        $this->addSql('ALTER TABLE question CHANGE text_type text_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'text\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_b6f7494e3b69a9af TO IDX_292708C63B69A9AF');
    }
}
