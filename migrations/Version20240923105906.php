<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923105906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire ADD actionnaire VARCHAR(255) DEFAULT NULL, ADD actionnairepart VARCHAR(255) DEFAULT NULL, DROP actionnaire1, DROP actionnaire1part');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire ADD actionnaire1 VARCHAR(255) DEFAULT NULL, ADD actionnaire1part VARCHAR(255) DEFAULT NULL, DROP actionnaire, DROP actionnairepart');
    }
}
