<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250802205936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires ADD user_id INT DEFAULT NULL, ADD plainte_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C46AF057B FOREIGN KEY (plainte_id) REFERENCES plaintes (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9BEC0C4A76ED395 ON commentaires (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9BEC0C46AF057B ON commentaires (plainte_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contacts ADD user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_33401573A76ED395 ON contacts (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes ADD user_id INT NOT NULL, ADD status_id INT NOT NULL, ADD type_plainte_id INT NOT NULL, ADD commune_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes ADD CONSTRAINT FK_8B695E73A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes ADD CONSTRAINT FK_8B695E736BF700BD FOREIGN KEY (status_id) REFERENCES status (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes ADD CONSTRAINT FK_8B695E731BACD35E FOREIGN KEY (type_plainte_id) REFERENCES typesplaintes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes ADD CONSTRAINT FK_8B695E73131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8B695E73A76ED395 ON plaintes (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8B695E736BF700BD ON plaintes (status_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8B695E731BACD35E ON plaintes (type_plainte_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8B695E73131A4F72 ON plaintes (commune_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses ADD user_id INT NOT NULL, ADD plainte_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC66AF057B FOREIGN KEY (plainte_id) REFERENCES plaintes (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1E512EC6A76ED395 ON reponses (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1E512EC66AF057B ON reponses (plainte_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD role_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1483A5E9D60322AC ON users (role_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C46AF057B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D9BEC0C4A76ED395 ON commentaires
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D9BEC0C46AF057B ON commentaires
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaires DROP user_id, DROP plainte_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes DROP FOREIGN KEY FK_8B695E73A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes DROP FOREIGN KEY FK_8B695E736BF700BD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes DROP FOREIGN KEY FK_8B695E731BACD35E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes DROP FOREIGN KEY FK_8B695E73131A4F72
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8B695E73A76ED395 ON plaintes
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8B695E736BF700BD ON plaintes
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8B695E731BACD35E ON plaintes
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8B695E73131A4F72 ON plaintes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plaintes DROP user_id, DROP status_id, DROP type_plainte_id, DROP commune_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_33401573A76ED395 ON contacts
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contacts DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC66AF057B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1E512EC6A76ED395 ON reponses
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1E512EC66AF057B ON reponses
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponses DROP user_id, DROP plainte_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1483A5E9D60322AC ON users
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP role_id
        SQL);
    }
}
