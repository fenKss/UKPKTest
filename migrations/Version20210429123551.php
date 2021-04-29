<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429123551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD title_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA9F87BD FOREIGN KEY (title_id) REFERENCES typed_field (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EA9F87BD ON question (title_id)');
        $this->addSql('ALTER TABLE question_option ADD body_id INT NOT NULL');
        $this->addSql('ALTER TABLE question_option ADD CONSTRAINT FK_5DDB2FB89B621D84 FOREIGN KEY (body_id) REFERENCES typed_field (id)');
        $this->addSql('CREATE INDEX IDX_5DDB2FB89B621D84 ON question_option (body_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA9F87BD');
        $this->addSql('DROP INDEX IDX_B6F7494EA9F87BD ON question');
        $this->addSql('ALTER TABLE question DROP title_id');
        $this->addSql('ALTER TABLE question_option DROP FOREIGN KEY FK_5DDB2FB89B621D84');
        $this->addSql('DROP INDEX IDX_5DDB2FB89B621D84 ON question_option');
        $this->addSql('ALTER TABLE question_option DROP body_id');
    }
}
