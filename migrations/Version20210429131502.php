<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429131502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE typed_field ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE typed_field ADD CONSTRAINT FK_587E33543DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_587E33543DA5256D ON typed_field (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE typed_field DROP FOREIGN KEY FK_587E33543DA5256D');
        $this->addSql('DROP INDEX IDX_587E33543DA5256D ON typed_field');
        $this->addSql('ALTER TABLE typed_field DROP image_id');
    }
}
