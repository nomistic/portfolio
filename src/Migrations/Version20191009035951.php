<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009035951 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, work_id_id INT NOT NULL, stage_no INT NOT NULL, date_due DATETIME DEFAULT NULL, budget_hours NUMERIC(10, 2) DEFAULT NULL, budget_setrate INT DEFAULT NULL, completed_hours NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_C27C936957BFE578 (work_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936957BFE578 FOREIGN KEY (work_id_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT NULL, CHANGE client_first client_first VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT NULL, CHANGE hours hours NUMERIC(10, 2) DEFAULT NULL, CHANGE date_submitted date_submitted DATE DEFAULT NULL, CHANGE date_published date_published DATE DEFAULT NULL, CHANGE work_type work_type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE stage');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_first client_first VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE hours hours NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE date_submitted date_submitted DATE DEFAULT \'NULL\', CHANGE date_published date_published DATE DEFAULT \'NULL\', CHANGE work_type work_type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
