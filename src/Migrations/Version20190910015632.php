<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910015632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT NULL, CHANGE client_first client_first VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE work ADD type_id INT DEFAULT NULL, ADD format_id INT DEFAULT NULL, ADD platform_id INT DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, ADD pub_url VARCHAR(255) DEFAULT NULL, ADD priv_url VARCHAR(255) DEFAULT NULL, ADD ghost_ind TINYINT(1) NOT NULL, ADD net_pay NUMERIC(10, 2) DEFAULT NULL, ADD hours NUMERIC(10, 2) DEFAULT NULL, ADD hourly TINYINT(1) NOT NULL, ADD date_submitted DATE DEFAULT NULL, ADD date_published DATE DEFAULT NULL, ADD work_type VARCHAR(255) DEFAULT NULL, CHANGE client_id_id client_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880D629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
        $this->addSql('CREATE INDEX IDX_534E6880C54C8C93 ON work (type_id)');
        $this->addSql('CREATE INDEX IDX_534E6880D629F605 ON work (format_id)');
        $this->addSql('CREATE INDEX IDX_534E6880FFE6496F ON work (platform_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E6880D629F605');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E6880FFE6496F');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E6880C54C8C93');
        $this->addSql('DROP TABLE format');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE client CHANGE parent_id parent_id INT DEFAULT NULL, CHANGE client_last client_last VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE client_first client_first VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX IDX_534E6880C54C8C93 ON work');
        $this->addSql('DROP INDEX IDX_534E6880D629F605 ON work');
        $this->addSql('DROP INDEX IDX_534E6880FFE6496F ON work');
        $this->addSql('ALTER TABLE work DROP type_id, DROP format_id, DROP platform_id, DROP notes, DROP pub_url, DROP priv_url, DROP ghost_ind, DROP net_pay, DROP hours, DROP hourly, DROP date_submitted, DROP date_published, DROP work_type, CHANGE client_id_id client_id_id INT DEFAULT NULL');
    }
}
