<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113124242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD project_owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE4372EA22 FOREIGN KEY (project_owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE4372EA22 ON project (project_owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE4372EA22');
        $this->addSql('DROP INDEX IDX_2FB3D0EE4372EA22 ON project');
        $this->addSql('ALTER TABLE project DROP project_owner_id');
    }
}
