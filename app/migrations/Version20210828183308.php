<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210828183308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inputs_tags (input_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FA09E9C436421AD6 (input_id), INDEX IDX_FA09E9C4BAD26311 (tag_id), PRIMARY KEY(input_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inputs_tags ADD CONSTRAINT FK_FA09E9C436421AD6 FOREIGN KEY (input_id) REFERENCES inputs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inputs_tags ADD CONSTRAINT FK_FA09E9C4BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags ADD code VARCHAR(45) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inputs_tags');
        $this->addSql('ALTER TABLE tags DROP code');
    }
}
