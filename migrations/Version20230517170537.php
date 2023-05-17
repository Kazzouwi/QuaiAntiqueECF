<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517170537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE table_reservation (table_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_7196BAE8ECFF285C (table_id), INDEX IDX_7196BAE8B83297E7 (reservation_id), PRIMARY KEY(table_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE table_reservation ADD CONSTRAINT FK_7196BAE8ECFF285C FOREIGN KEY (table_id) REFERENCES `table` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_reservation ADD CONSTRAINT FK_7196BAE8B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE table_reservation DROP FOREIGN KEY FK_7196BAE8ECFF285C');
        $this->addSql('ALTER TABLE table_reservation DROP FOREIGN KEY FK_7196BAE8B83297E7');
        $this->addSql('DROP TABLE table_reservation');
    }
}
