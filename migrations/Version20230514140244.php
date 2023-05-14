<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514140244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opening_hours ADD morning_opening_hour TIME DEFAULT NULL, ADD monring_closing_hour TIME DEFAULT NULL, ADD evening_opening_hour TIME DEFAULT NULL, ADD evening_closing_hour TIME DEFAULT NULL, DROP opening_hour, DROP closing_hour');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opening_hours ADD opening_hour TIME DEFAULT NULL, ADD closing_hour TIME DEFAULT NULL, DROP morning_opening_hour, DROP monring_closing_hour, DROP evening_opening_hour, DROP evening_closing_hour');
    }
}
