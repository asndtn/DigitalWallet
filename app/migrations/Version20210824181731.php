<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824181731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT FK_41A7E40F712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE inputs ADD CONSTRAINT FK_361A04E12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C892B1483 FOREIGN KEY (id_wallet_type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances DROP FOREIGN KEY FK_41A7E40F712520F3');
        $this->addSql('ALTER TABLE inputs DROP FOREIGN KEY FK_361A04E712520F3');
        $this->addSql('ALTER TABLE inputs DROP FOREIGN KEY FK_361A04E12469DE2');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C892B1483');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C38248176');
    }
}
