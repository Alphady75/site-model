<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823141319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apropos (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, online TINYINT(1) NOT NULL, annee_experience VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, bureau VARCHAR(255) DEFAULT NULL, whatsapp VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, historique LONGTEXT DEFAULT NULL, apropos LONGTEXT DEFAULT NULL, mot_dg_operation LONGTEXT DEFAULT NULL, photo_dg_operation VARCHAR(255) DEFAULT NULL, boite_postal VARCHAR(30) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, objectif LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, responsable_name VARCHAR(255) DEFAULT NULL, mots LONGTEXT DEFAULT NULL, dons_offerts INT DEFAULT NULL, dons_recus INT DEFAULT NULL, partenariats INT DEFAULT NULL, projets INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_2440FEAAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, demande_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, payer TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_6EEAA67D80E95E18 (demande_id), INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE communaute (id INT AUTO_INCREMENT NOT NULL, apropos_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_21C947994E4D9001 (apropos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, apropos_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(255) NOT NULL, INDEX IDX_89C2003F4E4D9001 (apropos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, service_id INT DEFAULT NULL, tarification_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, partenaire_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, dossier_juridique_id INT DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, periode_demarage VARCHAR(255) DEFAULT NULL, marque VARCHAR(255) DEFAULT NULL, statut_ae VARCHAR(30) DEFAULT NULL, domiciliation VARCHAR(255) DEFAULT NULL, comptastart VARCHAR(10) DEFAULT NULL, nom_societe VARCHAR(255) DEFAULT NULL, profession_declarant VARCHAR(255) DEFAULT NULL, type_activite VARCHAR(255) DEFAULT NULL, validate TINYINT(1) DEFAULT NULL, deja_cree_entreprise VARCHAR(255) DEFAULT NULL, payer TINYINT(1) DEFAULT NULL, etat VARCHAR(30) DEFAULT NULL, completed TINYINT(1) DEFAULT NULL, statut_bg VARCHAR(30) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_2694D7A5A76ED395 (user_id), INDEX IDX_2694D7A5ED5CA9E6 (service_id), INDEX IDX_2694D7A5A709F580 (tarification_id), INDEX IDX_2694D7A59B0F88B1 (activite_id), INDEX IDX_2694D7A598DE13AC (partenaire_id), INDEX IDX_2694D7A5F6203804 (statut_id), UNIQUE INDEX UNIQ_2694D7A583C0A846 (dossier_juridique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_juridique (id INT AUTO_INCREMENT NOT NULL, etape_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, document VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_9DFF44564A8CA2AD (etape_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier_juridique (id INT AUTO_INCREMENT NOT NULL, demande_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, statut VARCHAR(50) NOT NULL, statut_bg VARCHAR(20) DEFAULT NULL, terminer TINYINT(1) DEFAULT NULL, last_statut VARCHAR(30) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_418EC88A80E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, dossier_juridique_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, position INT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_285F75DD83C0A846 (dossier_juridique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, tarification_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, etat VARCHAR(30) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_605C9C98A709F580 (tarification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, nom VARCHAR(80) NOT NULL, fonction VARCHAR(80) DEFAULT NULL, online TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, site_url VARCHAR(255) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, resume VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, position INT DEFAULT NULL, online TINYINT(1) DEFAULT NULL, resume VARCHAR(255) DEFAULT NULL, tarif VARCHAR(255) DEFAULT NULL, mensualite VARCHAR(255) DEFAULT NULL, avantage VARCHAR(255) DEFAULT NULL, inscription VARCHAR(30) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarification (id INT AUTO_INCREMENT NOT NULL, statut_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, cout INT NOT NULL, type_cout VARCHAR(20) NOT NULL, description LONGTEXT DEFAULT NULL, recommander TINYINT(1) NOT NULL, online TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6132816F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temoignage (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, noms VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL, fonction VARCHAR(255) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, compte VARCHAR(30) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apropos ADD CONSTRAINT FK_2440FEAAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE communaute ADD CONSTRAINT FK_21C947994E4D9001 FOREIGN KEY (apropos_id) REFERENCES apropos (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F4E4D9001 FOREIGN KEY (apropos_id) REFERENCES apropos (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A709F580 FOREIGN KEY (tarification_id) REFERENCES tarification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A59B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A598DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A583C0A846 FOREIGN KEY (dossier_juridique_id) REFERENCES dossier_juridique (id)');
        $this->addSql('ALTER TABLE document_juridique ADD CONSTRAINT FK_9DFF44564A8CA2AD FOREIGN KEY (etape_id) REFERENCES etape (id)');
        $this->addSql('ALTER TABLE dossier_juridique ADD CONSTRAINT FK_418EC88A80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD83C0A846 FOREIGN KEY (dossier_juridique_id) REFERENCES dossier_juridique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formule ADD CONSTRAINT FK_605C9C98A709F580 FOREIGN KEY (tarification_id) REFERENCES tarification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_6132816F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apropos DROP FOREIGN KEY FK_2440FEAAA76ED395');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D80E95E18');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE communaute DROP FOREIGN KEY FK_21C947994E4D9001');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F4E4D9001');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5ED5CA9E6');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A709F580');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A59B0F88B1');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A598DE13AC');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5F6203804');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A583C0A846');
        $this->addSql('ALTER TABLE document_juridique DROP FOREIGN KEY FK_9DFF44564A8CA2AD');
        $this->addSql('ALTER TABLE dossier_juridique DROP FOREIGN KEY FK_418EC88A80E95E18');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD83C0A846');
        $this->addSql('ALTER TABLE formule DROP FOREIGN KEY FK_605C9C98A709F580');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_6132816F6203804');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE apropos');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE communaute');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE document_juridique');
        $this->addSql('DROP TABLE dossier_juridique');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE tarification');
        $this->addSql('DROP TABLE temoignage');
        $this->addSql('DROP TABLE user');
    }
}
