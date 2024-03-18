<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314214130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket ADD COLUMN photo2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD COLUMN photo3 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD COLUMN photo4 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__basket AS SELECT id, category_id, nom, description, prix, photo, sous_titre FROM basket');
        $this->addSql('DROP TABLE basket');
        $this->addSql('CREATE TABLE basket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, description CLOB NOT NULL, prix DOUBLE PRECISION NOT NULL, photo VARCHAR(255) NOT NULL, sous_titre VARCHAR(255) NOT NULL, CONSTRAINT FK_2246507B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO basket (id, category_id, nom, description, prix, photo, sous_titre) SELECT id, category_id, nom, description, prix, photo, sous_titre FROM __temp__basket');
        $this->addSql('DROP TABLE __temp__basket');
        $this->addSql('CREATE INDEX IDX_2246507B12469DE2 ON basket (category_id)');
    }
}
