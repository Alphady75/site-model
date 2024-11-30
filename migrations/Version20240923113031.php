<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923113031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche ADD civilite VARCHAR(20) DEFAULT NULL, ADD type_piece VARCHAR(40) DEFAULT NULL, ADD num_piece VARCHAR(255) DEFAULT NULL, ADD piece_recto VARCHAR(255) DEFAULT NULL, ADD piece_verso VARCHAR(255) DEFAULT NULL, ADD piece_delivre DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche DROP civilite, DROP type_piece, DROP num_piece, DROP piece_recto, DROP piece_verso, DROP piece_delivre');
    }
}
