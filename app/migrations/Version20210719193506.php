<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719193506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE iput_tag DROP FOREIGN KEY idInput');
        $this->addSql('ALTER TABLE input DROP FOREIGN KEY idInput_Category');
        $this->addSql('ALTER TABLE iput_tag DROP FOREIGN KEY idTag');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY fk_idUser');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY idWallet_Currency');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY idWallet_Type');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE input');
        $this->addSql('DROP TABLE input_category');
        $this->addSql('DROP TABLE iput_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wallet_currency');
        $this->addSql('DROP TABLE wallet_type');
        $this->addSql('DROP INDEX fk_idUser_idx ON wallet');
        $this->addSql('DROP INDEX idWallet_Currency_idx ON wallet');
        $this->addSql('DROP INDEX idWallet_Type_idx ON wallet');
        $this->addSql('ALTER TABLE wallet ADD id_user INT NOT NULL, ADD id_wallet_type INT NOT NULL, ADD id_wallet_currency INT NOT NULL, DROP idUser, DROP idWallet_Type, DROP idWallet_Currency, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balance (id INT NOT NULL, balance_amount INT DEFAULT NULL, idWallet INT DEFAULT NULL, INDEX idWallet_idx (idWallet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE input (id INT NOT NULL, idWallet INT DEFAULT NULL, idInput_Category INT DEFAULT NULL, input_amount INT DEFAULT NULL, date DATE DEFAULT NULL, input_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX idInput_Category_idx (idInput_Category), INDEX idWallet_idx (idWallet), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE input_category (id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE iput_tag (idInput INT DEFAULT NULL, idTag INT DEFAULT NULL, INDEX idInput_idx (idInput), INDEX idTag_idx (idTag)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, username VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, password VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, email VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, roles JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wallet_currency (id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wallet_type (id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT fk_idWallet FOREIGN KEY (idWallet) REFERENCES wallet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE input ADD CONSTRAINT idInput_Category FOREIGN KEY (idInput_Category) REFERENCES input_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE input ADD CONSTRAINT idWallet FOREIGN KEY (idWallet) REFERENCES wallet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE iput_tag ADD CONSTRAINT idInput FOREIGN KEY (idInput) REFERENCES input (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE iput_tag ADD CONSTRAINT idTag FOREIGN KEY (idTag) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE wallet ADD idUser INT DEFAULT NULL, ADD idWallet_Type INT DEFAULT NULL, ADD idWallet_Currency INT DEFAULT NULL, DROP id_user, DROP id_wallet_type, DROP id_wallet_currency, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT fk_idUser FOREIGN KEY (idUser) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT idWallet_Currency FOREIGN KEY (idWallet_Currency) REFERENCES wallet_currency (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT idWallet_Type FOREIGN KEY (idWallet_Type) REFERENCES wallet_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_idUser_idx ON wallet (idUser)');
        $this->addSql('CREATE INDEX idWallet_Currency_idx ON wallet (idWallet_Currency)');
        $this->addSql('CREATE INDEX idWallet_Type_idx ON wallet (idWallet_Type)');
    }
}
