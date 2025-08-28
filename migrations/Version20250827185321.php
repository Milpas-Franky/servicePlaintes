<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250827185321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_message CHANGE created_at created_at VARCHAR(255) NOT NULL');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_8B695E73C2E9D3C3 ON plaintes (code_suivi)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_message CHANGE created_at created_at DATETIME NOT NULL');
        // $this->addSql('DROP INDEX UNIQ_8B695E73C2E9D3C3 ON plaintes');
    }
}