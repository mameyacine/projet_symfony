<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223193040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_1230322259027487');
        $this->addSql('DROP INDEX IDX_1230322259027487 ON post_forum');
        $this->addSql('ALTER TABLE post_forum DROP theme_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum ADD theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_1230322259027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_1230322259027487 ON post_forum (theme_id)');
    }
}
