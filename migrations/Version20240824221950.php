<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240824221950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A598DE13AC');
        $this->addSql('DROP INDEX IDX_2694D7A598DE13AC ON demande');
        $this->addSql('ALTER TABLE demande DROP partenaire_id, DROP periode_demarage, DROP marque, DROP statut_ae, DROP domiciliation, DROP profession_declarant, DROP type_activite');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD partenaire_id INT DEFAULT NULL, ADD periode_demarage VARCHAR(255) DEFAULT NULL, ADD marque VARCHAR(255) DEFAULT NULL, ADD statut_ae VARCHAR(30) DEFAULT NULL, ADD domiciliation VARCHAR(255) DEFAULT NULL, ADD profession_declarant VARCHAR(255) DEFAULT NULL, ADD type_activite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A598DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_2694D7A598DE13AC ON demande (partenaire_id)');
    }
}
