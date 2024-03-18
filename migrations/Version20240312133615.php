<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312133615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE couleur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, color VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE couleur_basket (couleur_id INTEGER NOT NULL, basket_id INTEGER NOT NULL, PRIMARY KEY(couleur_id, basket_id), CONSTRAINT FK_CB359980C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CB3599801BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CB359980C31BA576 ON couleur_basket (couleur_id)');
        $this->addSql('CREATE INDEX IDX_CB3599801BE1FB52 ON couleur_basket (basket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE couleur');
        $this->addSql('DROP TABLE couleur_basket');
    }
}
