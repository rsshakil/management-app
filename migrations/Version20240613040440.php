<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240613040440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, nidno VARCHAR(255) DEFAULT NULL, ranking VARCHAR(255) DEFAULT NULL, photos VARCHAR(255) DEFAULT NULL, shareno VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) DEFAULT NULL, descrition LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, prirority VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, app_id VARCHAR(10) NOT NULL, status TINYINT(1) NOT NULL, password VARBINARY(255) NOT NULL, name VARCHAR(100) NOT NULL, secret_key VARCHAR(40) DEFAULT NULL, bank_account_id INT NOT NULL, payment_notice_url VARCHAR(255) DEFAULT NULL, transfer_notice_url VARCHAR(255) DEFAULT NULL, notice_email_status TINYINT(1) DEFAULT NULL, notice_emails LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, bank_name VARCHAR(50) NOT NULL, bank_code VARCHAR(4) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_account (id INT AUTO_INCREMENT NOT NULL, bank_id INT DEFAULT NULL, branch_id INT DEFAULT NULL, account_type TINYINT(1) NOT NULL, account_number VARCHAR(7) DEFAULT NULL, account_name VARCHAR(30) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_53A23E0A11C8FB41 (bank_id), INDEX IDX_53A23E0ADCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_application (id BIGINT AUTO_INCREMENT NOT NULL, request_log_id BIGINT NOT NULL, app_id INT NOT NULL, app_user_id VARCHAR(100) DEFAULT NULL, app_user_email VARCHAR(255) DEFAULT NULL, app_request_id INT NOT NULL, bank_account_id INT NOT NULL, estimate_amount INT NOT NULL, estimate_name VARCHAR(20) NOT NULL, balance INT DEFAULT NULL, free VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_branch (id INT AUTO_INCREMENT NOT NULL, bank_id INT DEFAULT NULL, branch_name VARCHAR(50) NOT NULL, branch_code VARCHAR(4) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_9BE3346211C8FB41 (bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_payment (id BIGINT AUTO_INCREMENT NOT NULL, app_id INT NOT NULL, bank_application_id BIGINT NOT NULL, bank_account_id INT NOT NULL, bank_statement_id BIGINT NOT NULL, app_user_id VARCHAR(100) DEFAULT NULL, app_user_email VARCHAR(255) DEFAULT NULL, app_request_id VARCHAR(50) DEFAULT NULL, transfer_name VARCHAR(50) NOT NULL, transfer_amount INT NOT NULL, amount_status INT NOT NULL, notify_status TINYINT(1) NOT NULL, is_paid TINYINT(1) NOT NULL, notify_count TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_43BCECA344045140 (bank_statement_id), INDEX IDX_43BCECA37987212D (app_id), INDEX IDX_43BCECA3A95B7614 (bank_application_id), INDEX IDX_43BCECA312CB990C (bank_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_payment_notify_log (id INT AUTO_INCREMENT NOT NULL, bank_payment_id BIGINT NOT NULL, notify_status TINYINT(1) DEFAULT NULL, notify_url VARCHAR(255) NOT NULL, notify_data JSON NOT NULL COMMENT \'(DC2Type:json)\', notify_count TINYINT(1) DEFAULT NULL, notified_at DATETIME NOT NULL, response_code SMALLINT NOT NULL, response_body LONGTEXT NOT NULL, response_verbose LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7F7D730F8D63650D (bank_payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_transfer (id BIGINT AUTO_INCREMENT NOT NULL, transfer_request_id INT NOT NULL, bank_id INT NOT NULL, bank_branch_id INT NOT NULL, account_type INT NOT NULL, account_number VARCHAR(7) NOT NULL, transfer_name VARCHAR(50) NOT NULL, transfer_amount INT NOT NULL, transfer_date DATE NOT NULL, transfer_status TINYINT(1) NOT NULL, notify_status TINYINT(1) NOT NULL, notify_count TINYINT(1) NOT NULL, transferred_at DATETIME DEFAULT NULL, notified_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_transfer_notify_log (id BIGINT AUTO_INCREMENT NOT NULL, bank_transfer_id BIGINT DEFAULT NULL, notify_status TINYINT(1) DEFAULT NULL, notify_url VARCHAR(255) NOT NULL, notify_data JSON NOT NULL COMMENT \'(DC2Type:json)\', notify_count INT DEFAULT NULL, notified_at DATETIME NOT NULL, response_code SMALLINT NOT NULL, response_body LONGTEXT NOT NULL, response_verbose LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_735B1B7671FBFED0 (bank_transfer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deposit (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, amount INT NOT NULL, payment_method VARCHAR(255) DEFAULT NULL, receipt VARCHAR(255) DEFAULT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_95DB9D399B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, amount INT DEFAULT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, amount INT DEFAULT NULL, remarks LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE investment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, amount INT DEFAULT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_logs (id BIGINT AUTO_INCREMENT NOT NULL, request_time DATETIME NOT NULL, request_data LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_token (id BIGINT AUTO_INCREMENT NOT NULL, app_id VARCHAR(255) NOT NULL, app_user_id VARCHAR(50) NOT NULL, token VARCHAR(40) DEFAULT NULL, expiration DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BDF55A634A3353D8 (app_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0A11C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE bank_account ADD CONSTRAINT FK_53A23E0ADCD6CC49 FOREIGN KEY (branch_id) REFERENCES bank_branch (id)');
        $this->addSql('ALTER TABLE bank_branch ADD CONSTRAINT FK_9BE3346211C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE bank_payment ADD CONSTRAINT FK_43BCECA37987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE bank_payment ADD CONSTRAINT FK_43BCECA3A95B7614 FOREIGN KEY (bank_application_id) REFERENCES bank_application (id)');
        $this->addSql('ALTER TABLE bank_payment ADD CONSTRAINT FK_43BCECA312CB990C FOREIGN KEY (bank_account_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE bank_payment_notify_log ADD CONSTRAINT FK_7F7D730F8D63650D FOREIGN KEY (bank_payment_id) REFERENCES bank_payment (id)');
        $this->addSql('ALTER TABLE bank_transfer_notify_log ADD CONSTRAINT FK_735B1B7671FBFED0 FOREIGN KEY (bank_transfer_id) REFERENCES bank_transfer (id)');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D399B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0A11C8FB41');
        $this->addSql('ALTER TABLE bank_account DROP FOREIGN KEY FK_53A23E0ADCD6CC49');
        $this->addSql('ALTER TABLE bank_branch DROP FOREIGN KEY FK_9BE3346211C8FB41');
        $this->addSql('ALTER TABLE bank_payment DROP FOREIGN KEY FK_43BCECA37987212D');
        $this->addSql('ALTER TABLE bank_payment DROP FOREIGN KEY FK_43BCECA3A95B7614');
        $this->addSql('ALTER TABLE bank_payment DROP FOREIGN KEY FK_43BCECA312CB990C');
        $this->addSql('ALTER TABLE bank_payment_notify_log DROP FOREIGN KEY FK_7F7D730F8D63650D');
        $this->addSql('ALTER TABLE bank_transfer_notify_log DROP FOREIGN KEY FK_735B1B7671FBFED0');
        $this->addSql('ALTER TABLE deposit DROP FOREIGN KEY FK_95DB9D399B6B5FBA');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE bank_application');
        $this->addSql('DROP TABLE bank_branch');
        $this->addSql('DROP TABLE bank_payment');
        $this->addSql('DROP TABLE bank_payment_notify_log');
        $this->addSql('DROP TABLE bank_transfer');
        $this->addSql('DROP TABLE bank_transfer_notify_log');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE deposit');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE investment');
        $this->addSql('DROP TABLE request_logs');
        $this->addSql('DROP TABLE user_token');
    }
}
