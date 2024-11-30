<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825010431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_6132816F6203804');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_6132816F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_6132816F6203804');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_6132816F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
    }
}
