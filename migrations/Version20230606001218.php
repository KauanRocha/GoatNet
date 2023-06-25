<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606001218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transaction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE goat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE goat (id INT NOT NULL, codigo DOUBLE PRECISION NOT NULL, leite_prod DOUBLE PRECISION NOT NULL, racao_cons DOUBLE PRECISION NOT NULL, peso DOUBLE PRECISION NOT NULL, data_nasc DATE NOT NULL, abatido DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT fk_64c19c19d86650f');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT fk_723705d112469de2');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT fk_723705d19d86650f');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE goat_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" (email)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, user_id_id INT DEFAULT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_64c19c19d86650f ON category (user_id_id)');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, category_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, descricao VARCHAR(255) NOT NULL, valor DOUBLE PRECISION NOT NULL, status BOOLEAN NOT NULL, data DATE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_723705d19d86650f ON transaction (user_id_id)');
        $this->addSql('CREATE INDEX idx_723705d112469de2 ON transaction (category_id)');
        $this->addSql('COMMENT ON COLUMN transaction.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT fk_64c19c19d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_723705d112469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_723705d19d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE goat');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS NULL');
    }
}
