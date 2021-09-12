<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210912141134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balances (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, balance_amount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_41A7E40F712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, code VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currencies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inputs (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, category_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_361A04E712520F3 (wallet_id), INDEX IDX_361A04E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inputs_tags (input_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FA09E9C436421AD6 (input_id), INDEX IDX_FA09E9C4BAD26311 (tag_id), PRIMARY KEY(input_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) DEFAULT NULL, code VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallets (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, currency_id INT NOT NULL, owner_id INT UNSIGNED NOT NULL, INDEX IDX_967AAA6CC54C8C93 (type_id), INDEX IDX_967AAA6C38248176 (currency_id), INDEX IDX_967AAA6C7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT FK_41A7E40F712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE inputs_tags ADD CONSTRAINT FK_FA09E9C436421AD6 FOREIGN KEY (input_id) REFERENCES inputs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inputs_tags ADD CONSTRAINT FK_FA09E9C4BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6CC54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inputs DROP FOREIGN KEY FK_361A04E12469DE2');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C38248176');
        $this->addSql('ALTER TABLE inputs_tags DROP FOREIGN KEY FK_FA09E9C436421AD6');
        $this->addSql('ALTER TABLE inputs_tags DROP FOREIGN KEY FK_FA09E9C4BAD26311');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6CC54C8C93');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C7E3C61F9');
        $this->addSql('ALTER TABLE balances DROP FOREIGN KEY FK_41A7E40F712520F3');
        $this->addSql('ALTER TABLE inputs DROP FOREIGN KEY FK_361A04E712520F3');
        $this->addSql('DROP TABLE balances');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE inputs');
        $this->addSql('DROP TABLE inputs_tags');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE wallets');
    }
}
