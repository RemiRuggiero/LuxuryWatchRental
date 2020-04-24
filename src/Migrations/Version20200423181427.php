<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423181427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE picture');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number VARCHAR(45) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE town town VARCHAR(255) DEFAULT NULL, CHANGE zipcode zipcode VARCHAR(45) DEFAULT NULL, CHANGE country country VARCHAR(45) DEFAULT NULL, CHANGE identity_card identity_card VARCHAR(255) DEFAULT NULL, CHANGE activation_token activation_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, watch_model_id INT DEFAULT NULL, picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, INDEX IDX_16DB4F89108A8B86 (watch_model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89108A8B86 FOREIGN KEY (watch_model_id) REFERENCES watch_model (id)');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE town town VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE zipcode zipcode VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE identity_card identity_card VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE activation_token activation_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
