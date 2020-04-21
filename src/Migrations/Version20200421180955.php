<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421180955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery ADD delivery_company_id INT NOT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1089DE8DF2 FOREIGN KEY (delivery_company_id) REFERENCES delivery_company (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3781EC1089DE8DF2 ON delivery (delivery_company_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC1089DE8DF2');
        $this->addSql('DROP INDEX UNIQ_3781EC1089DE8DF2 ON delivery');
        $this->addSql('ALTER TABLE delivery DROP delivery_company_id');
    }
}
