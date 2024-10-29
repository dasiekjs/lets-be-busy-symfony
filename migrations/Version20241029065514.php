<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029065514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE issue (id VARCHAR(16) NOT NULL, project_id VARCHAR(8) NOT NULL, title VARCHAR(128) NOT NULL, content CLOB NOT NULL, created_at DATE NOT NULL --(DC2Type:date_immutable)
        , updated_at DATE NOT NULL --(DC2Type:date_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_12AD233E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_12AD233E166D1F9C ON issue (project_id)');
        $this->addSql('CREATE TABLE project (id VARCHAR(8) NOT NULL, name VARCHAR(64) NOT NULL, description CLOB NOT NULL, created_at DATE NOT NULL --(DC2Type:date_immutable)
        , updated_at DATE NOT NULL --(DC2Type:date_immutable)
        , PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE project');
    }
}
