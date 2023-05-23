<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522204852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_allergen TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_favorite TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, meal_category VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_ingredient (meal_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_FCC3CEFA639666D6 (meal_id), INDEX IDX_FCC3CEFA933FE08C (ingredient_id), PRIMARY KEY(meal_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opening_hours (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL, morning_opening_hour TIME DEFAULT NULL, morning_closing_hour TIME DEFAULT NULL, evening_opening_hour TIME DEFAULT NULL, evening_closing_hour TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reservation_table_id INT NOT NULL, customer_id INT DEFAULT NULL, date DATE NOT NULL, hour TIME NOT NULL, number_of_people INT NOT NULL, INDEX IDX_42C84955714ACA48 (reservation_table_id), INDEX IDX_42C849559395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, places INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, guests INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ingredient (user_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_CCC8BE9CA76ED395 (user_id), INDEX IDX_CCC8BE9C933FE08C (ingredient_id), PRIMARY KEY(user_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal_ingredient ADD CONSTRAINT FK_FCC3CEFA639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_ingredient ADD CONSTRAINT FK_FCC3CEFA933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955714ACA48 FOREIGN KEY (reservation_table_id) REFERENCES `table` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_ingredient ADD CONSTRAINT FK_CCC8BE9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ingredient ADD CONSTRAINT FK_CCC8BE9C933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
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
