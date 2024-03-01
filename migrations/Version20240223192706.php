<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223192706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_12303222F9295384');
        $this->addSql('DROP INDEX IDX_12303222F9295384 ON post_forum');
        $this->addSql('ALTER TABLE post_forum CHANGE courses_id course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_12303222591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_12303222591CC992 ON post_forum (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_12303222591CC992');
        $this->addSql('DROP INDEX IDX_12303222591CC992 ON post_forum');
        $this->addSql('ALTER TABLE post_forum CHANGE course_id courses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_12303222F9295384 FOREIGN KEY (courses_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_12303222F9295384 ON post_forum (courses_id)');
    }
}
