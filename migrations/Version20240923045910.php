<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923045910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, demande_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATETIME DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, nationalite VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, sit_mat VARCHAR(255) NOT NULL, regime_mat VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_4C13CC7880E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, demande_id INT NOT NULL, fondateur VARCHAR(255) DEFAULT NULL, fondateur2 VARCHAR(255) DEFAULT NULL, fondateur3 VARCHAR(255) DEFAULT NULL, denomination VARCHAR(255) DEFAULT NULL, durree VARCHAR(255) DEFAULT NULL, siegesociale VARCHAR(255) DEFAULT NULL, objetsocial VARCHAR(255) DEFAULT NULL, capitalsocial VARCHAR(255) DEFAULT NULL, partinterval VARCHAR(255) DEFAULT NULL, numeraires VARCHAR(255) DEFAULT NULL, nature VARCHAR(255) DEFAULT NULL, industrie VARCHAR(255) DEFAULT NULL, part VARCHAR(255) DEFAULT NULL, president VARCHAR(255) DEFAULT NULL, prestelephone VARCHAR(255) DEFAULT NULL, sectadmin VARCHAR(255) DEFAULT NULL, sectadmintelephone VARCHAR(255) DEFAULT NULL, tresorier VARCHAR(255) DEFAULT NULL, tresoriertelephone VARCHAR(255) DEFAULT NULL, civilite VARCHAR(255) DEFAULT NULL, nom_commercial VARCHAR(255) DEFAULT NULL, sitmat VARCHAR(255) DEFAULT NULL, actionnaire1 VARCHAR(255) DEFAULT NULL, actionnaire1part VARCHAR(255) DEFAULT NULL, actionnaire2 VARCHAR(255) DEFAULT NULL, actionnaire2part VARCHAR(255) DEFAULT NULL, actionnaire3 VARCHAR(255) DEFAULT NULL, actionnaire3part VARCHAR(255) DEFAULT NULL, mode_admin VARCHAR(255) DEFAULT NULL, etat_civil_nom VARCHAR(255) DEFAULT NULL, commisaire_titulaire VARCHAR(255) DEFAULT NULL, commissaire_suppleant VARCHAR(255) DEFAULT NULL, gerantnom VARCHAR(255) DEFAULT NULL, gerantprenom VARCHAR(255) DEFAULT NULL, gerantprofession VARCHAR(255) DEFAULT NULL, geranttelephone VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_7A64DAF80E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC7880E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC7880E95E18');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF80E95E18');
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE questionnaire');
    }
}
