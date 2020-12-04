<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204063219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE olymp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_option (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, is_correct TINYINT(1) NOT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_5DDB2FB81E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, INDEX IDX_D87F7E0C82F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour (id INT AUTO_INCREMENT NOT NULL, olymp_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, is_valid TINYINT(1) NOT NULL, started_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, INDEX IDX_6AD1F9699F4F18A4 (olymp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_test (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tour_id INT NOT NULL, language_id INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_A2FE32C5A76ED395 (user_id), INDEX IDX_A2FE32C515ED8D43 (tour_id), INDEX IDX_A2FE32C582F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, INDEX IDX_F143BFAD1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant_question (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, type VARCHAR(100) NOT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_292708C63B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_option ADD CONSTRAINT FK_5DDB2FB81E27F6BF FOREIGN KEY (question_id) REFERENCES variant_question (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F9699F4F18A4 FOREIGN KEY (olymp_id) REFERENCES olymp (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C515ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE user_test ADD CONSTRAINT FK_A2FE32C582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE variant_question ADD CONSTRAINT FK_292708C63B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C82F1BAF4');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C582F1BAF4');
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F9699F4F18A4');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD1E5D0459');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C515ED8D43');
        $this->addSql('ALTER TABLE user_test DROP FOREIGN KEY FK_A2FE32C5A76ED395');
        $this->addSql('ALTER TABLE variant_question DROP FOREIGN KEY FK_292708C63B69A9AF');
        $this->addSql('ALTER TABLE question_option DROP FOREIGN KEY FK_5DDB2FB81E27F6BF');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE olymp');
        $this->addSql('DROP TABLE question_option');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE tour');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_test');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE variant_question');
    }
}
