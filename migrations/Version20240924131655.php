<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924131655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP INDEX UNIQ_4C13CC7880E95E18, ADD INDEX IDX_4C13CC7880E95E18 (demande_id)');
        $this->addSql('ALTER TABLE fiche CHANGE demande_id demande_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP INDEX IDX_4C13CC7880E95E18, ADD UNIQUE INDEX UNIQ_4C13CC7880E95E18 (demande_id)');
        $this->addSql('ALTER TABLE fiche CHANGE demande_id demande_id INT NOT NULL');
    }
}
