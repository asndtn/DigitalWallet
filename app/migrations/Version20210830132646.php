<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830132646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallets ADD owner_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_967AAA6C7E3C61F9 ON wallets (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C7E3C61F9');
        $this->addSql('DROP INDEX IDX_967AAA6C7E3C61F9 ON wallets');
        $this->addSql('ALTER TABLE wallets DROP owner_id');
    }
}
