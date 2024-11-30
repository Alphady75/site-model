<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923051838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC7880E95E18');
        $this->addSql('DROP INDEX IDX_4C13CC7880E95E18 ON fiche');
        $this->addSql('ALTER TABLE fiche DROP demande_id');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF80E95E18');
        $this->addSql('DROP INDEX IDX_7A64DAF80E95E18 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP demande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC7880E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE INDEX IDX_4C13CC7880E95E18 ON fiche (demande_id)');
        $this->addSql('ALTER TABLE questionnaire ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF80E95E18 ON questionnaire (demande_id)');
    }
}
