<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421184916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location ADD user_id INT NOT NULL, ADD delivery_id INT NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CBA76ED395 ON location (user_id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB12136921 ON location (delivery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA76ED395');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB12136921');
        $this->addSql('DROP INDEX IDX_5E9E89CBA76ED395 ON location');
        $this->addSql('DROP INDEX IDX_5E9E89CB12136921 ON location');
        $this->addSql('ALTER TABLE location DROP user_id, DROP delivery_id');
    }
}
