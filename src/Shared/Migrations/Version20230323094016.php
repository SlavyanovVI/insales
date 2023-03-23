<?php

declare(strict_types=1);

namespace App\Shared\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323094016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, insales_id BIGINT UNSIGNED NOT NULL, url VARCHAR(500) NOT NULL, password VARCHAR(255) NOT NULL, password_token VARCHAR(255) NOT NULL, last_export_date DATETIME DEFAULT NULL, ready_export_client BIGINT UNSIGNED DEFAULT 0 NOT NULL, bounced_email_count BIGINT DEFAULT 0 NOT NULL, fake_email_count BIGINT DEFAULT 0 NOT NULL, install_notification_send TINYINT(1) DEFAULT 0 NOT NULL, create_at DATETIME DEFAULT NULL, update_at DATETIME DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', auth_login VARCHAR(255) DEFAULT NULL, auth_password VARCHAR(255) DEFAULT NULL, auth_authentication_success TINYINT(1) DEFAULT 0 NOT NULL, auth_authentication_error VARCHAR(500) DEFAULT NULL, import_order_import_finish TINYINT(1) DEFAULT 0 NOT NULL, import_client_import_finish TINYINT(1) DEFAULT 0 NOT NULL, import_last_order_page INT UNSIGNED DEFAULT 1 NOT NULL, options_address_book_id BIGINT UNSIGNED DEFAULT NULL, options_address_book_title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_groups (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, application_id BIGINT UNSIGNED DEFAULT NULL, group_id BIGINT UNSIGNED NOT NULL, title VARCHAR(500) NOT NULL, create_at DATETIME DEFAULT NULL, update_at DATETIME DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_A5CB72C33E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, application_id BIGINT UNSIGNED DEFAULT NULL, client_group_id BIGINT UNSIGNED DEFAULT NULL, payment_order DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, payment_order_count BIGINT UNSIGNED DEFAULT 0 NOT NULL, order_count BIGINT UNSIGNED DEFAULT 0 NOT NULL, exported TINYINT(1) DEFAULT 0 NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, middlename VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(70) DEFAULT NULL, client_create_at DATETIME DEFAULT NULL, first_order_payment_date DATETIME DEFAULT NULL, last_order_payment_date DATETIME DEFAULT NULL, client_insales_ids JSON NOT NULL, dasha_mail_id BIGINT UNSIGNED DEFAULT NULL, dasha_mail_email VARCHAR(255) DEFAULT NULL, dasha_mail_bounced_email TINYINT(1) DEFAULT 0 NOT NULL, dasha_mail_fake_email TINYINT(1) DEFAULT 0 NOT NULL, create_at DATETIME DEFAULT NULL, update_at DATETIME DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_C82E743E030ACD (application_id), INDEX IDX_C82E74D0B2E982 (client_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, application_id BIGINT UNSIGNED DEFAULT NULL, client_id BIGINT UNSIGNED DEFAULT NULL, payed TINYINT(1) DEFAULT 1 NOT NULL, order_id BIGINT UNSIGNED NOT NULL, order_number VARCHAR(255) NOT NULL, order_price DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, delivery_price DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, create_order_at DATETIME NOT NULL, create_at DATETIME DEFAULT NULL, update_at DATETIME DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_E52FFDEE3E030ACD (application_id), INDEX IDX_E52FFDEE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_groups ADD CONSTRAINT FK_A5CB72C33E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E743E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74D0B2E982 FOREIGN KEY (client_group_id) REFERENCES client_groups (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_groups DROP FOREIGN KEY FK_A5CB72C33E030ACD');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E743E030ACD');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74D0B2E982');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE3E030ACD');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE19EB6921');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE client_groups');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
