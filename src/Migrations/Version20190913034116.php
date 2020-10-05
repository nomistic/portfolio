<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190913034116 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject_work (subject_id INT NOT NULL, work_id INT NOT NULL, INDEX IDX_C184EC5B23EDC87 (subject_id), INDEX IDX_C184EC5BBB3453DB (work_id), PRIMARY KEY(subject_id, work_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject_work ADD CONSTRAINT FK_C184EC5B23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subject_work ADD CONSTRAINT FK_C184EC5BBB3453DB FOREIGN KEY (work_id) REFERENCES work (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT NULL, CHANGE client_first client_first VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT NULL, CHANGE hours hours NUMERIC(10, 2) DEFAULT NULL, CHANGE date_submitted date_submitted DATE DEFAULT NULL, CHANGE date_published date_published DATE DEFAULT NULL, CHANGE work_type work_type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subject_work DROP FOREIGN KEY FK_C184EC5B23EDC87');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subject_work');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_first client_first VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE work CHANGE client_id_id client_id_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE format_id format_id INT DEFAULT NULL, CHANGE platform_id platform_id INT DEFAULT NULL, CHANGE net_pay net_pay NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE hours hours NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE date_submitted date_submitted DATE DEFAULT \'NULL\', CHANGE date_published date_published DATE DEFAULT \'NULL\', CHANGE work_type work_type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
