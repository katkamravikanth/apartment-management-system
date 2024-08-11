<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240811074456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4DB9D91CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartment (id INT AUTO_INCREMENT NOT NULL, president_id INT DEFAULT NULL, secretary_id INT DEFAULT NULL, tresurer_id INT DEFAULT NULL, security_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address_1 VARCHAR(255) NOT NULL, address_2 VARCHAR(255) DEFAULT NULL, village VARCHAR(255) DEFAULT NULL, mandal VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, pincode VARCHAR(255) NOT NULL, contact_number VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4D7E6854B40A33C7 (president_id), UNIQUE INDEX UNIQ_4D7E6854A2A63DB2 (secretary_id), UNIQUE INDEX UNIQ_4D7E685412B548EE (tresurer_id), UNIQUE INDEX UNIQ_4D7E68546DBE4214 (security_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, flat_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_6354059D3331C94 (flat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flat (id INT AUTO_INCREMENT NOT NULL, apartment_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, flat_number VARCHAR(255) NOT NULL, floor VARCHAR(255) NOT NULL, rooms INT NOT NULL, baths INT NOT NULL, balcony INT DEFAULT NULL, flat_sft INT NOT NULL, furnished_type VARCHAR(255) DEFAULT NULL, flat_facing VARCHAR(255) DEFAULT NULL, water_connections VARCHAR(255) DEFAULT NULL, gas_connections VARCHAR(255) DEFAULT NULL, rent INT DEFAULT NULL, maintenance_fee INT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_554AAA44176DFE85 (apartment_id), UNIQUE INDEX UNIQ_554AAA447E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flat_user (flat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E5D200BDD3331C94 (flat_id), INDEX IDX_E5D200BDA76ED395 (user_id), PRIMARY KEY(flat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, transaction_type_id INT DEFAULT NULL, payer_id INT DEFAULT NULL, payee_id INT DEFAULT NULL, transaction_id VARCHAR(255) NOT NULL, amount INT NOT NULL, mode VARCHAR(255) NOT NULL, description MEDIUMTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_723705D1B3E6B071 (transaction_type_id), INDEX IDX_723705D1C17AD9A9 (payer_id), INDEX IDX_723705D1CB4B68F (payee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, user_type_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, phone VARCHAR(255) NOT NULL, alternate_phone VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_8D93D6499D419299 (user_type_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_flat_history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, flat_id INT DEFAULT NULL, from_date DATE NOT NULL, to_date DATE DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C302C4B2A76ED395 (user_id), INDEX IDX_C302C4B2D3331C94 (flat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E6854B40A33C7 FOREIGN KEY (president_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E6854A2A63DB2 FOREIGN KEY (secretary_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E685412B548EE FOREIGN KEY (tresurer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E68546DBE4214 FOREIGN KEY (security_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA447E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE flat_user ADD CONSTRAINT FK_E5D200BDD3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flat_user ADD CONSTRAINT FK_E5D200BDA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B3E6B071 FOREIGN KEY (transaction_type_id) REFERENCES transaction_type (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C17AD9A9 FOREIGN KEY (payer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CB4B68F FOREIGN KEY (payee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6499D419299 FOREIGN KEY (user_type_id) REFERENCES user_type (id)');
        $this->addSql('ALTER TABLE user_flat_history ADD CONSTRAINT FK_C302C4B2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_flat_history ADD CONSTRAINT FK_C302C4B2D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA76ED395');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E6854B40A33C7');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E6854A2A63DB2');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E685412B548EE');
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E68546DBE4214');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059D3331C94');
        $this->addSql('ALTER TABLE flat DROP FOREIGN KEY FK_554AAA44176DFE85');
        $this->addSql('ALTER TABLE flat DROP FOREIGN KEY FK_554AAA447E3C61F9');
        $this->addSql('ALTER TABLE flat_user DROP FOREIGN KEY FK_E5D200BDD3331C94');
        $this->addSql('ALTER TABLE flat_user DROP FOREIGN KEY FK_E5D200BDA76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B3E6B071');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C17AD9A9');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CB4B68F');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499D419299');
        $this->addSql('ALTER TABLE user_flat_history DROP FOREIGN KEY FK_C302C4B2A76ED395');
        $this->addSql('ALTER TABLE user_flat_history DROP FOREIGN KEY FK_C302C4B2D3331C94');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE flat');
        $this->addSql('DROP TABLE flat_user');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_type');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_flat_history');
        $this->addSql('DROP TABLE user_type');
    }
}
