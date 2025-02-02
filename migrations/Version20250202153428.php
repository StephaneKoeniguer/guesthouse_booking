<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202153428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, guest_id_id INT DEFAULT NULL, INDEX IDX_4DA2396ABA0943 (guest_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reservation_room (reservations_id INT NOT NULL, rooms_id INT NOT NULL, INDEX IDX_64A69CF3D9A7F869 (reservations_id), INDEX IDX_64A69CF38E2368AB (rooms_id), PRIMARY KEY(reservations_id, rooms_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2396ABA0943 FOREIGN KEY (guest_id_id) REFERENCES guests (id)');
        $this->addSql('ALTER TABLE reservation_room ADD CONSTRAINT FK_64A69CF3D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_room ADD CONSTRAINT FK_64A69CF38E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2396ABA0943');
        $this->addSql('ALTER TABLE reservation_room DROP FOREIGN KEY FK_64A69CF3D9A7F869');
        $this->addSql('ALTER TABLE reservation_room DROP FOREIGN KEY FK_64A69CF38E2368AB');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reservation_room');
    }
}
