<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421181811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location ADD watch_entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBBBF9D3AF FOREIGN KEY (watch_entity_id) REFERENCES watch_entity (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CBBBF9D3AF ON location (watch_entity_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBBF9D3AF');
        $this->addSql('DROP INDEX UNIQ_5E9E89CBBBF9D3AF ON location');
        $this->addSql('ALTER TABLE location DROP watch_entity_id');
    }
}
