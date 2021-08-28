<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210828112031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balances (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, balance_amount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_41A7E40F712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, code VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inputs (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, category_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_361A04E712520F3 (wallet_id), INDEX IDX_361A04E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT FK_41A7E40F712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C892B1483');
        $this->addSql('DROP INDEX IDX_967AAA6C892B1483 ON wallets');
        $this->addSql('ALTER TABLE wallets ADD currency_id INT NOT NULL, CHANGE id_wallet_type_id type_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6CC54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
        $this->addSql('CREATE INDEX IDX_967AAA6CC54C8C93 ON wallets (type_id)');
        $this->addSql('CREATE INDEX IDX_967AAA6C38248176 ON wallets (currency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inputs DROP FOREIGN KEY FK_361A04E12469DE2');
        $this->addSql('DROP TABLE balances');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE inputs');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6CC54C8C93');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C38248176');
        $this->addSql('DROP INDEX IDX_967AAA6CC54C8C93 ON wallets');
        $this->addSql('DROP INDEX IDX_967AAA6C38248176 ON wallets');
        $this->addSql('ALTER TABLE wallets ADD id_wallet_type_id INT NOT NULL, DROP type_id, DROP currency_id');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C892B1483 FOREIGN KEY (id_wallet_type_id) REFERENCES types (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_967AAA6C892B1483 ON wallets (id_wallet_type_id)');
    }
}
