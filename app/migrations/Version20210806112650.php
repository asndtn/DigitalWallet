<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806112650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallets CHANGE id_wallet_type id_wallet_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C892B1483 FOREIGN KEY (id_wallet_type_id) REFERENCES types (id)');
        $this->addSql('CREATE INDEX IDX_967AAA6C892B1483 ON wallets (id_wallet_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C892B1483');
        $this->addSql('DROP INDEX IDX_967AAA6C892B1483 ON wallets');
        $this->addSql('ALTER TABLE wallets CHANGE id_wallet_type_id id_wallet_type INT NOT NULL');
    }
}
