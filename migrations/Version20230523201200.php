<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523201200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO `user` (`id`, `email`, `roles`, `password`, `guests`) VALUES (NULL, \'Kazzouwi59@gmail.com\', \'[\"ROLE_ADMIN\"]\', \'$2y$13$bHTfFWNr12Zltlzk2QJZMeu.DAWKZYbScSSQwzBalOnXhoU7GqQTq\', 1);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal_ingredient DROP FOREIGN KEY FK_FCC3CEFA639666D6');
        $this->addSql('ALTER TABLE meal_ingredient DROP FOREIGN KEY FK_FCC3CEFA933FE08C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955714ACA48');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559395C3F3');
        $this->addSql('ALTER TABLE user_ingredient DROP FOREIGN KEY FK_CCC8BE9CA76ED395');
        $this->addSql('ALTER TABLE user_ingredient DROP FOREIGN KEY FK_CCC8BE9C933FE08C');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_ingredient');
        $this->addSql('DROP TABLE opening_hours');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_ingredient');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
