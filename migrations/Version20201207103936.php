<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207103936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE olymp_language (olymp_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_5743E4049F4F18A4 (olymp_id), INDEX IDX_5743E40482F1BAF4 (language_id), PRIMARY KEY(olymp_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE olymp_language ADD CONSTRAINT FK_5743E4049F4F18A4 FOREIGN KEY (olymp_id) REFERENCES olymp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE olymp_language ADD CONSTRAINT FK_5743E40482F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE olymp_language');
    }
}
