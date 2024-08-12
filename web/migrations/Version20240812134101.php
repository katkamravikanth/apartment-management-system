<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812134101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apartment (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, size INT NOT NULL, rent_amount NUMERIC(10, 0) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4D7E68544D2A7E12 (building_id), INDEX IDX_4D7E68547E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, num_of_floors INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, lease_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D8698A7616678C77 (uploader_id), INDEX IDX_D8698A76176DFE85 (apartment_id), INDEX IDX_D8698A76D3CA542C (lease_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, renter_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, amount NUMERIC(10, 0) NOT NULL, due_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_90651744E289A545 (renter_id), INDEX IDX_90651744176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lease (id INT AUTO_INCREMENT NOT NULL, renter_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', rent_amount NUMERIC(10, 0) NOT NULL, security_deposit NUMERIC(10, 0) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E6C77495E289A545 (renter_id), INDEX IDX_E6C77495176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_request (id INT AUTO_INCREMENT NOT NULL, requester_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4261CA0DED442CF4 (requester_id), INDEX IDX_4261CA0D176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, recipient_id INT DEFAULT NULL, content LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_BF5476CAE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, renter_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, invoice_id INT DEFAULT NULL, amount NUMERIC(10, 0) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_6D28840DE289A545 (renter_id), INDEX IDX_6D28840D176DFE85 (apartment_id), INDEX IDX_6D28840D2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E68544D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E68547E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7616678C77 FOREIGN KEY (uploader_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76D3CA542C FOREIGN KEY (lease_id) REFERENCES lease (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744E289A545 FOREIGN KEY (renter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE lease ADD CONSTRAINT FK_E6C77495E289A545 FOREIGN KEY (renter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lease ADD CONSTRAINT FK_E6C77495176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0DED442CF4 FOREIGN KEY (requester_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0D176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DE289A545 FOREIGN KEY (renter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E68544D2A7E12');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E68547E3C61F9');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7616678C77');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76176DFE85');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76D3CA542C');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744E289A545');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744176DFE85');
        $this->addSql('ALTER TABLE lease DROP FOREIGN KEY FK_E6C77495E289A545');
        $this->addSql('ALTER TABLE lease DROP FOREIGN KEY FK_E6C77495176DFE85');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0DED442CF4');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0D176DFE85');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE92F8F78');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DE289A545');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D176DFE85');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D2989F1FD');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE lease');
        $this->addSql('DROP TABLE maintenance_request');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
    }
}
