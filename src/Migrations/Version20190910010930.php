<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910010930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD parent_id INT DEFAULT NULL, DROP parent, CHANGE client_last client_last VARCHAR(255) DEFAULT NULL, CHANGE client_first client_first VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455727ACA70 FOREIGN KEY (parent_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_C7440455727ACA70 ON client (parent_id)');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455727ACA70');
        $this->addSql('DROP INDEX IDX_C7440455727ACA70 ON client');
        $this->addSql('ALTER TABLE client ADD parent INT DEFAULT NULL, DROP parent_id, CHANGE client_last client_last VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_first client_first VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL');
    }
}
