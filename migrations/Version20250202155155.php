<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202155155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payements (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(10, 0) NOT NULL, payment_date DATE NOT NULL, payment_method VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, reservation_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_866EB2DC3C3B4EF0 (reservation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, rating INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, room_id_id INT DEFAULT NULL, INDEX IDX_6970EB0F35F83FFC (room_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE room_image (id INT AUTO_INCREMENT NOT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, room_id_id INT DEFAULT NULL, INDEX IDX_8F81A5F435F83FFC (room_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE payements ADD CONSTRAINT FK_866EB2DC3C3B4EF0 FOREIGN KEY (reservation_id_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F35F83FFC FOREIGN KEY (room_id_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE room_image ADD CONSTRAINT FK_8F81A5F435F83FFC FOREIGN KEY (room_id_id) REFERENCES rooms (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payements DROP FOREIGN KEY FK_866EB2DC3C3B4EF0');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F35F83FFC');
        $this->addSql('ALTER TABLE room_image DROP FOREIGN KEY FK_8F81A5F435F83FFC');
        $this->addSql('DROP TABLE payements');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE room_image');
    }
}
