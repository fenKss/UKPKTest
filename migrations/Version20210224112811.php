<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224112811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, size INT NOT NULL, type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE olymp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE olymp_language (olymp_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_5743E4049F4F18A4 (olymp_id), INDEX IDX_5743E40482F1BAF4 (language_id), PRIMARY KEY(olymp_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE possible_answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, is_correct TINYINT(1) NOT NULL, text LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_3D79739D1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, type VARCHAR(100) NOT NULL, title LONGTEXT DEFAULT NULL, title_type VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E3B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, tour_id INT NOT NULL, INDEX IDX_D87F7E0C82F1BAF4 (language_id), INDEX IDX_D87F7E0C15ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour (id INT AUTO_INCREMENT NOT NULL, olymp_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, started_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, published_at DATETIME DEFAULT NULL, tour_index SMALLINT NOT NULL, INDEX IDX_6AD1F9699F4F18A4 (olymp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, born_at DATETIME NOT NULL, address VARCHAR(255) DEFAULT NULL, study_place VARCHAR(255) DEFAULT NULL, class VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_test (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, language_id INT NOT NULL, variant_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, result_json LONGTEXT DEFAULT NULL, result_saved_at DATETIME NOT NULL, INDEX IDX_A2FE32C5A76ED395 (user_id), INDEX IDX_A2FE32C582F1BAF4 (language_id), INDEX IDX_A2FE32C53B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, INDEX IDX_F143BFAD1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE olymp_language ADD CONSTRAINT FK_5743E4049F4F18A4 FOREIGN KEY (olymp_id) REFERENCES olymp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE olymp_language ADD CONSTRAINT FK_5743E40482F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE possible_answer ADD CONSTRAINT FK_3D79739D1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E3B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C15ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F9699F4F18A4 FOREIGN KEY (olymp_id) REFERENCES olymp (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C53B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE olymp_language DROP FOREIGN KEY FK_5743E40482F1BAF4');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C82F1BAF4');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C582F1BAF4');
        $this->addSql('ALTER TABLE olymp_language DROP FOREIGN KEY FK_5743E4049F4F18A4');
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F9699F4F18A4');
        $this->addSql('ALTER TABLE possible_answer DROP FOREIGN KEY FK_3D79739D1E27F6BF');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD1E5D0459');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C15ED8D43');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C5A76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E3B69A9AF');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C53B69A9AF');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE olymp');
        $this->addSql('DROP TABLE olymp_language');
        $this->addSql('DROP TABLE possible_answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE tour');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_test');
        $this->addSql('DROP TABLE variant');
    }
}
