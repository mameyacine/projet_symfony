<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222132831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note_student (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, qcms_id INT DEFAULT NULL, score INT NOT NULL, INDEX IDX_36856BA967B3B43D (users_id), INDEX IDX_36856BA9D83BD9B9 (qcms_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_forum (id INT AUTO_INCREMENT NOT NULL, students_id INT DEFAULT NULL, themes_id INT DEFAULT NULL, courses_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date DATE NOT NULL, INDEX IDX_123032221AD8D010 (students_id), INDEX IDX_1230322294F4A9D2 (themes_id), INDEX IDX_12303222F9295384 (courses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note_student ADD CONSTRAINT FK_36856BA967B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note_student ADD CONSTRAINT FK_36856BA9D83BD9B9 FOREIGN KEY (qcms_id) REFERENCES qcm (id)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_123032221AD8D010 FOREIGN KEY (students_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_1230322294F4A9D2 FOREIGN KEY (themes_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_12303222F9295384 FOREIGN KEY (courses_id) REFERENCES course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_student DROP FOREIGN KEY FK_36856BA967B3B43D');
        $this->addSql('ALTER TABLE note_student DROP FOREIGN KEY FK_36856BA9D83BD9B9');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_123032221AD8D010');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_1230322294F4A9D2');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_12303222F9295384');
        $this->addSql('DROP TABLE note_student');
        $this->addSql('DROP TABLE post_forum');
    }
}
