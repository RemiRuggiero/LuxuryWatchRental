<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421174732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, tracking_number VARCHAR(45) NOT NULL, address VARCHAR(255) NOT NULL, town VARCHAR(255) NOT NULL, zipcode VARCHAR(45) NOT NULL, country VARCHAR(45) NOT NULL, returned_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, logo VARCHAR(255) NOT NULL, tracking_link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, location_number VARCHAR(45) NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, is_paid INT NOT NULL, bill_number VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, picture_1 VARCHAR(255) NOT NULL, picture_2 VARCHAR(255) NOT NULL, picture_3 VARCHAR(255) NOT NULL, picture_4 VARCHAR(255) NOT NULL, picture_5 VARCHAR(255) NOT NULL, picture_6 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(90) NOT NULL, lastname VARCHAR(90) NOT NULL, birthday DATE NOT NULL, gender INT NOT NULL, phone_number VARCHAR(45) NOT NULL, address VARCHAR(255) NOT NULL, town VARCHAR(255) NOT NULL, zipcode VARCHAR(45) NOT NULL, country VARCHAR(45) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, identity_card VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_entity (id INT AUTO_INCREMENT NOT NULL, serial_number VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(45) NOT NULL, model VARCHAR(45) NOT NULL, gender INT NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(45) NOT NULL, price DOUBLE PRECISION NOT NULL, movement VARCHAR(45) NOT NULL, diameter VARCHAR(45) NOT NULL, waterproof VARCHAR(45) NOT NULL, glass VARCHAR(45) NOT NULL, function VARCHAR(45) NOT NULL, watch_clasps VARCHAR(45) NOT NULL, bracelet VARCHAR(45) NOT NULL, watch_dial VARCHAR(45) NOT NULL, deposit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE delivery_company');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE watch_entity');
        $this->addSql('DROP TABLE watch_model');
    }
}
