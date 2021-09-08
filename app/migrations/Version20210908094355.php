<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908094355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE balances');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balances (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, balance_amount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_41A7E40F712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT FK_41A7E40F712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
