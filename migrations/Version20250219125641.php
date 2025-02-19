<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219125641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amenities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE amenities_rooms (amenities_id INT NOT NULL, rooms_id INT NOT NULL, INDEX IDX_E3A53DA5B92D5262 (amenities_id), INDEX IDX_E3A53DA58E2368AB (rooms_id), PRIMARY KEY(amenities_id, rooms_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE amenities_rooms ADD CONSTRAINT FK_E3A53DA5B92D5262 FOREIGN KEY (amenities_id) REFERENCES amenities (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amenities_rooms ADD CONSTRAINT FK_E3A53DA58E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenities_rooms DROP FOREIGN KEY FK_E3A53DA5B92D5262');
        $this->addSql('ALTER TABLE amenities_rooms DROP FOREIGN KEY FK_E3A53DA58E2368AB');
        $this->addSql('DROP TABLE amenities');
        $this->addSql('DROP TABLE amenities_rooms');
    }
}
