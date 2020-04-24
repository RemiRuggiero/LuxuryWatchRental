<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424123825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, delivery_company_id INT NOT NULL, tracking_number VARCHAR(45) NOT NULL, address VARCHAR(255) NOT NULL, town VARCHAR(255) NOT NULL, zipcode VARCHAR(45) NOT NULL, country VARCHAR(45) NOT NULL, returned_at DATE NOT NULL, UNIQUE INDEX UNIQ_3781EC1089DE8DF2 (delivery_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, logo VARCHAR(255) NOT NULL, tracking_link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, watch_entity_id INT NOT NULL, user_id INT NOT NULL, delivery_id INT NOT NULL, location_number VARCHAR(45) NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, is_paid INT NOT NULL, bill_number VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CBBBF9D3AF (watch_entity_id), INDEX IDX_5E9E89CBA76ED395 (user_id), INDEX IDX_5E9E89CB12136921 (delivery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, watch_model_id INT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_16DB4F89108A8B86 (watch_model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, gender INT NOT NULL, phone_number VARCHAR(45) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, town VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, identity_card VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', activation_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_entity (id INT AUTO_INCREMENT NOT NULL, watch_model_id INT NOT NULL, serial_number VARCHAR(45) NOT NULL, INDEX IDX_4968B8F4108A8B86 (watch_model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(45) NOT NULL, model VARCHAR(45) NOT NULL, gender INT NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(45) NOT NULL, price DOUBLE PRECISION NOT NULL, movement VARCHAR(45) NOT NULL, diameter VARCHAR(45) NOT NULL, waterproof VARCHAR(45) NOT NULL, glass VARCHAR(45) NOT NULL, function VARCHAR(45) NOT NULL, watch_clasps VARCHAR(45) NOT NULL, bracelet VARCHAR(45) NOT NULL, watch_dial VARCHAR(45) NOT NULL, deposit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1089DE8DF2 FOREIGN KEY (delivery_company_id) REFERENCES delivery_company (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBBBF9D3AF FOREIGN KEY (watch_entity_id) REFERENCES watch_entity (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89108A8B86 FOREIGN KEY (watch_model_id) REFERENCES watch_model (id)');
        $this->addSql('ALTER TABLE watch_entity ADD CONSTRAINT FK_4968B8F4108A8B86 FOREIGN KEY (watch_model_id) REFERENCES watch_model (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB12136921');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC1089DE8DF2');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA76ED395');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBBF9D3AF');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89108A8B86');
        $this->addSql('ALTER TABLE watch_entity DROP FOREIGN KEY FK_4968B8F4108A8B86');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE delivery_company');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE watch_entity');
        $this->addSql('DROP TABLE watch_model');
    }
}
