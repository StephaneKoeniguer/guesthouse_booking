<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221104137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payements RENAME INDEX uniq_866eb2dc3c3b4ef0 TO UNIQ_866EB2DCB83297E7');
        $this->addSql('ALTER TABLE reservations RENAME INDEX idx_4da2396aba0943 TO IDX_4DA2399A4AA658');
        $this->addSql('ALTER TABLE reviews RENAME INDEX idx_6970eb0f35f83ffc TO IDX_6970EB0F54177093');
        $this->addSql('ALTER TABLE room_image RENAME INDEX idx_8f81a5f435f83ffc TO IDX_8F81A5F454177093');
        $this->addSql('ALTER TABLE rooms ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CA11A96A76ED395 ON rooms (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations RENAME INDEX idx_4da2399a4aa658 TO IDX_4DA2396ABA0943');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A96A76ED395');
        $this->addSql('DROP INDEX IDX_7CA11A96A76ED395 ON rooms');
        $this->addSql('ALTER TABLE rooms DROP user_id');
        $this->addSql('ALTER TABLE room_image RENAME INDEX idx_8f81a5f454177093 TO IDX_8F81A5F435F83FFC');
        $this->addSql('ALTER TABLE payements RENAME INDEX uniq_866eb2dcb83297e7 TO UNIQ_866EB2DC3C3B4EF0');
        $this->addSql('ALTER TABLE reviews RENAME INDEX idx_6970eb0f54177093 TO IDX_6970EB0F35F83FFC');
    }
}
