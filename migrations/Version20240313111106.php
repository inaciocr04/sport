<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313111106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE basket_couleur');
        $this->addSql('DROP TABLE tailles');
        $this->addSql('DROP TABLE tailles_basket');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_couleur (basket_id INTEGER NOT NULL, couleur_id INTEGER NOT NULL, PRIMARY KEY(basket_id, couleur_id), CONSTRAINT FK_F8AA97FC1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F8AA97FCC31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F8AA97FCC31BA576 ON basket_couleur (couleur_id)');
        $this->addSql('CREATE INDEX IDX_F8AA97FC1BE1FB52 ON basket_couleur (basket_id)');
        $this->addSql('CREATE TABLE tailles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, chiffre_taille VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE tailles_basket (tailles_id INTEGER NOT NULL, basket_id INTEGER NOT NULL, PRIMARY KEY(tailles_id, basket_id), CONSTRAINT FK_A7C1CAC41AEC613E FOREIGN KEY (tailles_id) REFERENCES tailles (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A7C1CAC41BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A7C1CAC41BE1FB52 ON tailles_basket (basket_id)');
        $this->addSql('CREATE INDEX IDX_A7C1CAC41AEC613E ON tailles_basket (tailles_id)');
    }
}
