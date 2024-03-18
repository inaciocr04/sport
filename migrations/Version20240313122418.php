<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313122418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_taille (basket_id INTEGER NOT NULL, taille_id INTEGER NOT NULL, PRIMARY KEY(basket_id, taille_id), CONSTRAINT FK_B00A2AC11BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B00A2AC1FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B00A2AC11BE1FB52 ON basket_taille (basket_id)');
        $this->addSql('CREATE INDEX IDX_B00A2AC1FF25611A ON basket_taille (taille_id)');
        $this->addSql('DROP TABLE taille_basket');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taille_basket (taille_id INTEGER NOT NULL, basket_id INTEGER NOT NULL, PRIMARY KEY(taille_id, basket_id), CONSTRAINT FK_42C9885DFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C9885D1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_42C9885D1BE1FB52 ON taille_basket (basket_id)');
        $this->addSql('CREATE INDEX IDX_42C9885DFF25611A ON taille_basket (taille_id)');
        $this->addSql('DROP TABLE basket_taille');
    }
}
