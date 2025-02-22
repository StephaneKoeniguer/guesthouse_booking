<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222103843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews ADD guest_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F9A4AA658 FOREIGN KEY (guest_id) REFERENCES guests (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F9A4AA658 ON reviews (guest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F9A4AA658');
        $this->addSql('DROP INDEX IDX_6970EB0F9A4AA658 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP guest_id');
    }
}
