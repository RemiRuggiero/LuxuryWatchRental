<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421185203 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE watch_entity ADD watch_model_id INT NOT NULL');
        $this->addSql('ALTER TABLE watch_entity ADD CONSTRAINT FK_4968B8F4108A8B86 FOREIGN KEY (watch_model_id) REFERENCES watch_model (id)');
        $this->addSql('CREATE INDEX IDX_4968B8F4108A8B86 ON watch_entity (watch_model_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE watch_entity DROP FOREIGN KEY FK_4968B8F4108A8B86');
        $this->addSql('DROP INDEX IDX_4968B8F4108A8B86 ON watch_entity');
        $this->addSql('ALTER TABLE watch_entity DROP watch_model_id');
    }
}
