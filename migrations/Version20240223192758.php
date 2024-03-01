<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223192758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_123032221AD8D010');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_1230322294F4A9D2');
        $this->addSql('DROP INDEX IDX_123032221AD8D010 ON post_forum');
        $this->addSql('DROP INDEX IDX_1230322294F4A9D2 ON post_forum');
        $this->addSql('ALTER TABLE post_forum ADD student_id INT DEFAULT NULL, ADD theme_id INT DEFAULT NULL, DROP students_id, DROP themes_id');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_12303222CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_1230322259027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_12303222CB944F1A ON post_forum (student_id)');
        $this->addSql('CREATE INDEX IDX_1230322259027487 ON post_forum (theme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_12303222CB944F1A');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_1230322259027487');
        $this->addSql('DROP INDEX IDX_12303222CB944F1A ON post_forum');
        $this->addSql('DROP INDEX IDX_1230322259027487 ON post_forum');
        $this->addSql('ALTER TABLE post_forum ADD students_id INT DEFAULT NULL, ADD themes_id INT DEFAULT NULL, DROP student_id, DROP theme_id');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_123032221AD8D010 FOREIGN KEY (students_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_1230322294F4A9D2 FOREIGN KEY (themes_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_123032221AD8D010 ON post_forum (students_id)');
        $this->addSql('CREATE INDEX IDX_1230322294F4A9D2 ON post_forum (themes_id)');
    }
}
