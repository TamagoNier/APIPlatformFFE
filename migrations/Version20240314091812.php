<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314091812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, nb_places_maxi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_inscription (atelier_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_20EC8DC882E2CF35 (atelier_id), INDEX IDX_20EC8DC85DAC5993 (inscription_id), PRIMARY KEY(atelier_id, inscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_chambre (id INT AUTO_INCREMENT NOT NULL, libelle_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) NOT NULL, tel VARCHAR(10) NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, inscription_id INT DEFAULT NULL, licencie_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CFF65260E7927C74 (email), UNIQUE INDEX UNIQ_CFF652605DAC5993 (inscription_id), UNIQUE INDEX UNIQ_CFF65260B56DCD74 (licencie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(10) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_restauration (inscription_id INT NOT NULL, restauration_id INT NOT NULL, INDEX IDX_FAFBDB85DAC5993 (inscription_id), INDEX IDX_FAFBDB87C6CB929 (restauration_id), PRIMARY KEY(inscription_id, restauration_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, idclub_id INT NOT NULL, idqualite_id INT NOT NULL, numlicence VARCHAR(11) NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(60) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(10) NOT NULL, mail VARCHAR(255) NOT NULL, dateadhesion DATETIME NOT NULL, INDEX IDX_3B755612BE1D585C (idclub_id), INDEX IDX_3B7556126B9A984A (idqualite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nuite (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, categorie_id INT NOT NULL, inscription_id INT DEFAULT NULL, date_nuitee DATETIME NOT NULL, INDEX IDX_8D4CB7153243BB18 (hotel_id), INDEX IDX_8D4CB715BCF5E72D (categorie_id), INDEX IDX_8D4CB7155DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposer (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, categorie_id INT NOT NULL, tarif_nuite DOUBLE PRECISION NOT NULL, INDEX IDX_21866C153243BB18 (hotel_id), INDEX IDX_21866C15BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qualite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restauration (id INT AUTO_INCREMENT NOT NULL, date_restauration DATETIME NOT NULL, type_repas VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_atelier (theme_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_B8D81D0059027487 (theme_id), INDEX IDX_B8D81D0082E2CF35 (atelier_id), PRIMARY KEY(theme_id, atelier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, licence_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D64926EF07C9 (licence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacation (id INT AUTO_INCREMENT NOT NULL, atelier_id INT NOT NULL, dateheure_debut DATETIME NOT NULL, dateheure_fin DATETIME NOT NULL, INDEX IDX_E3DADF7582E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC882E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC85DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652605DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260B56DCD74 FOREIGN KEY (licencie_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE inscription_restauration ADD CONSTRAINT FK_FAFBDB85DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_restauration ADD CONSTRAINT FK_FAFBDB87C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612BE1D585C FOREIGN KEY (idclub_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556126B9A984A FOREIGN KEY (idqualite_id) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB7153243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB715BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB7155DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C153243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C15BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE theme_atelier ADD CONSTRAINT FK_B8D81D0059027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_atelier ADD CONSTRAINT FK_B8D81D0082E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64926EF07C9 FOREIGN KEY (licence_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE vacation ADD CONSTRAINT FK_E3DADF7582E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC882E2CF35');
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC85DAC5993');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652605DAC5993');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260B56DCD74');
        $this->addSql('ALTER TABLE inscription_restauration DROP FOREIGN KEY FK_FAFBDB85DAC5993');
        $this->addSql('ALTER TABLE inscription_restauration DROP FOREIGN KEY FK_FAFBDB87C6CB929');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612BE1D585C');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556126B9A984A');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB7153243BB18');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB715BCF5E72D');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB7155DAC5993');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C153243BB18');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C15BCF5E72D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE theme_atelier DROP FOREIGN KEY FK_B8D81D0059027487');
        $this->addSql('ALTER TABLE theme_atelier DROP FOREIGN KEY FK_B8D81D0082E2CF35');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64926EF07C9');
        $this->addSql('ALTER TABLE vacation DROP FOREIGN KEY FK_E3DADF7582E2CF35');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE atelier_inscription');
        $this->addSql('DROP TABLE categorie_chambre');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_restauration');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE nuite');
        $this->addSql('DROP TABLE proposer');
        $this->addSql('DROP TABLE qualite');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE restauration');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_atelier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vacation');
    }
}
