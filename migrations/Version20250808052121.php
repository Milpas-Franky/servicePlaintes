<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250808052121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification de la colonne user_id dans contacts en la rendant NOT NULL, avec suppression et recréation de la clé étrangère';
    }

    public function up(Schema $schema): void
    {
        // 1️⃣ Supprimer la contrainte FK
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');

        // 2️⃣ Modifier la colonne
        $this->addSql('ALTER TABLE contacts CHANGE user_id user_id INT NOT NULL');

        // 3️⃣ Recréer la contrainte FK
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // 1️⃣ Supprimer la contrainte FK
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');

        // 2️⃣ Revenir à nullable
        $this->addSql('ALTER TABLE contacts CHANGE user_id user_id INT DEFAULT NULL');

        // 3️⃣ Recréer la contrainte FK
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }
}
