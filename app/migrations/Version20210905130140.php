<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210905130140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances ADD wallet_id INT');
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT FK_41A7E40F712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41A7E40F712520F3 ON balances (wallet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances DROP FOREIGN KEY FK_41A7E40F712520F3');
        $this->addSql('DROP INDEX UNIQ_41A7E40F712520F3 ON balances');
        $this->addSql('ALTER TABLE balances DROP wallet_id');
    }
}
