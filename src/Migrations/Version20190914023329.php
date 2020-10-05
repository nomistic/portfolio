<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190914023329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT NULL, CHANGE client_first client_first VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT NULL, CHANGE hours hours NUMERIC(10, 2) DEFAULT NULL, CHANGE date_submitted date_submitted DATE DEFAULT NULL, CHANGE date_published date_published DATE DEFAULT NULL, CHANGE work_type work_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE subject_work DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE subject_work ADD PRIMARY KEY (work_id, subject_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_first client_first VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE subject_work DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE subject_work ADD PRIMARY KEY (subject_id, work_id)');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE hours hours NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE date_submitted date_submitted DATE DEFAULT \'NULL\', CHANGE date_published date_published DATE DEFAULT \'NULL\', CHANGE work_type work_type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
